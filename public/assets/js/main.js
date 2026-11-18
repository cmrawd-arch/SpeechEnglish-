/**
 * =============================================================================
 * Speech English — Scripts d'interaction et validations côté navigateur
 * =============================================================================
 */

document.addEventListener('DOMContentLoaded', () => {

    /* =========================================================================
       1. VALIDATIONS CÔTÉ NAVIGATEUR : FORMULAIRE D'INSCRIPTION
       ========================================================================= */
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        const nomInput         = document.getElementById('nom');
        const prenomInput      = document.getElementById('prenom');
        const emailInput       = document.getElementById('email');
        const passwordInput    = document.getElementById('mot_de_passe');
        const confirmInput     = document.getElementById('mot_de_passe_confirm');

        const nomError         = document.getElementById('nom-error');
        const prenomError      = document.getElementById('prenom-error');
        const emailError       = document.getElementById('email-error');
        const passwordError    = document.getElementById('mot-de-passe-error');
        const confirmError     = document.getElementById('mot-de-passe-confirm-error');

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        function setError(input, errorElement, message) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function setSuccess(input, errorElement) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        }

        nomInput.addEventListener('input', () => {
            const val = nomInput.value.trim();
            if (val === '') {
                setError(nomInput, nomError, 'Le nom est obligatoire.');
            } else if (val.length < 2) {
                setError(nomInput, nomError, 'Le nom doit comporter au moins 2 caractères.');
            } else {
                setSuccess(nomInput, nomError);
            }
        });

        prenomInput.addEventListener('input', () => {
            const val = prenomInput.value.trim();
            if (val === '') {
                setError(prenomInput, prenomError, 'Le prénom est obligatoire.');
            } else if (val.length < 2) {
                setError(prenomInput, prenomError, 'Le prénom doit comporter au moins 2 caractères.');
            } else {
                setSuccess(prenomInput, prenomError);
            }
        });

        emailInput.addEventListener('input', () => {
            const val = emailInput.value.trim();
            if (val === '') {
                setError(emailInput, emailError, "L'adresse email est obligatoire.");
            } else if (!emailRegex.test(val)) {
                setError(emailInput, emailError, 'Veuillez saisir une adresse email valide (ex. nom@domaine.fr).');
            } else {
                setSuccess(emailInput, emailError);
            }
        });

        passwordInput.addEventListener('input', () => {
            const val = passwordInput.value;
            if (val === '') {
                setError(passwordInput, passwordError, 'Le mot de passe est obligatoire.');
            } else if (val.length < 6) {
                setError(passwordInput, passwordError, 'Le mot de passe doit comporter au moins 6 caractères.');
            } else {
                setSuccess(passwordInput, passwordError);
            }

            if (confirmInput.value !== '') {
                validatePasswordConfirm();
            }
        });

        function validatePasswordConfirm() {
            const pass = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm === '') {
                setError(confirmInput, confirmError, 'Veuillez confirmer votre mot de passe.');
                return false;
            } else if (pass !== confirm) {
                setError(confirmInput, confirmError, 'Les deux mots de passe ne correspondent pas.');
                return false;
            } else {
                setSuccess(confirmInput, confirmError);
                return true;
            }
        }

        confirmInput.addEventListener('input', validatePasswordConfirm);

        registerForm.addEventListener('submit', (e) => {
            let isValid = true;

            const nomVal = nomInput.value.trim();
            if (nomVal === '' || nomVal.length < 2) {
                setError(nomInput, nomError, nomVal === '' ? 'Le nom est obligatoire.' : 'Au moins 2 caractères requis.');
                isValid = false;
            }

            const prenomVal = prenomInput.value.trim();
            if (prenomVal === '' || prenomVal.length < 2) {
                setError(prenomInput, prenomError, prenomVal === '' ? 'Le prénom est obligatoire.' : 'Au moins 2 caractères requis.');
                isValid = false;
            }

            const emailVal = emailInput.value.trim();
            if (emailVal === '' || !emailRegex.test(emailVal)) {
                setError(emailInput, emailError, emailVal === '' ? "L'adresse email est obligatoire." : 'Adresse email invalide.');
                isValid = false;
            }

            const passVal = passwordInput.value;
            if (passVal === '' || passVal.length < 6) {
                setError(passwordInput, passwordError, passVal === '' ? 'Le mot de passe est obligatoire.' : 'Au moins 6 caractères requis.');
                isValid = false;
            }

            if (!validatePasswordConfirm()) {
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                const firstInvalid = registerForm.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });
    }

    /* =========================================================================
       2. INTERACTIONS DU TABLEAU DE BORD (DASHBOARD)
       ========================================================================= */

    // A. Tiroir déroulant des leçons par niveau (Easy, Basic, Hard)
    const levelToggles = document.querySelectorAll('.btn-level-toggle');
    levelToggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');
            const drawer = document.getElementById(targetId);
            if (!drawer) return;

            const isHidden = drawer.hasAttribute('hidden');
            if (isHidden) {
                drawer.removeAttribute('hidden');
                btn.textContent = '📖 Fermer les leçons ▲';
                btn.classList.add('active');
            } else {
                drawer.setAttribute('hidden', '');
                // Réinitialiser le texte
                const lessonCount = drawer.querySelectorAll('.lesson-item').length;
                btn.textContent = `📖 Voir les leçons (${lessonCount})`;
                btn.classList.remove('active');
            }
        });
    });

    // B. Défilement fluide (Smooth Scroll) pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetSelector = this.getAttribute('href');
            if (targetSelector === '#') return;

            const targetElement = document.querySelector(targetSelector);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Mise à jour de l'état actif dans la barre supérieure
                document.querySelectorAll('.top-nav .nav-item').forEach(nav => nav.classList.remove('active'));
                if (this.classList.contains('nav-item')) {
                    this.classList.add('active');
                }
            }
        });
    });

    // C. Animation des jauges de progression au chargement
    const progressBars = document.querySelectorAll('.progress-bar, .track span');
    progressBars.forEach(bar => {
        const targetWidth = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
            bar.style.width = targetWidth;
        }, 150);
    });

});
