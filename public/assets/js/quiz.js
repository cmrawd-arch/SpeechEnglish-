/**
 * =============================================================================
 * Speech English — Moteur d'exécution interactive des Quiz
 * =============================================================================
 *
 * Fonctionnalités :
 * 1. Affichage pas-à-pas des questions et propositions (QCM).
 * 2. Sélection d'une proposition avec retour visuel immédiat.
 * 3. Validation asynchrone côté serveur (sécurisée : la bonne réponse n'est pas
 *    envoyée avant la validation).
 * 4. Verrouillage irrévocable des options dès la validation pour empêcher
 *    toute modification ultérieure.
 * 5. Restitution visuelle immédiate (vert pour correct, rouge pour faux).
 * 6. Affichage de l'explication pédagogique détaillée extraite de MySQL.
 * 7. Transition vers la question suivante.
 * 8. Calcul et enregistrement du score final en BDD avec redirection vers le bilan.
 */

document.addEventListener('DOMContentLoaded', function () {
    const questionsDeck = document.getElementById('questions-deck');
    if (!questionsDeck) {
        return;
    }

    const quizId = parseInt(questionsDeck.dataset.quizId, 10);
    const validateUrl = questionsDeck.dataset.validateUrl;
    const finishUrl = questionsDeck.dataset.finishUrl;
    const totalQuestions = parseInt(questionsDeck.dataset.totalQuestions, 10);

    const currentScoreVal = document.getElementById('current-score-val');
    const stepCurrent = document.getElementById('step-current');
    const stepPct = document.getElementById('step-pct');
    const progressBar = document.getElementById('quiz-progress-bar');

    let currentStepIndex = 1;

    // -------------------------------------------------------------------------
    // 1. Gestion de la sélection d'une proposition (carte radio)
    // -------------------------------------------------------------------------
    document.querySelectorAll('.proposal-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            const radio = card.querySelector('input[type="radio"]');
            if (!radio || radio.disabled) {
                return;
            }

            // Décocher visuellement les autres cartes de la même question
            const questionStep = card.closest('.question-step');
            if (!questionStep) return;

            questionStep.querySelectorAll('.proposal-card').forEach(function (c) {
                c.classList.remove('selected');
            });

            // Activer la carte cliquée
            card.classList.add('selected');
            radio.checked = true;

            // Débloquer le bouton "Valider ma réponse"
            const validateBtn = questionStep.querySelector('.btn-validate');
            if (validateBtn && !validateBtn.disabled) {
                // Déjà débloqué
            } else if (validateBtn) {
                validateBtn.disabled = false;
                validateBtn.classList.add('ready');
            }

            // Cacher tout éventuel message d'erreur
            const errorMsg = questionStep.querySelector('.validation-error-msg');
            if (errorMsg) {
                errorMsg.hidden = true;
            }
        });
    });

    // -------------------------------------------------------------------------
    // 2. Validation d'une réponse (Requête POST sécurisée vers le serveur)
    // -------------------------------------------------------------------------
    document.querySelectorAll('.btn-validate').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const questionId = parseInt(btn.dataset.qid, 10);
            const questionStep = document.getElementById('question-step-' + questionId);
            if (!questionStep) return;

            const selectedRadio = questionStep.querySelector('input[type="radio"]:checked');
            const errorMsg = document.getElementById('error-msg-' + questionId);

            if (!selectedRadio) {
                if (errorMsg) {
                    errorMsg.hidden = false;
                }
                return;
            }

            const optionId = parseInt(selectedRadio.value, 10);

            // Désactivation immédiate du bouton pour prévenir les doubles envois
            btn.disabled = true;
            btn.textContent = 'Vérification en cours...';

            // Appel AJAX / Fetch vers le serveur
            fetch(validateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    question_id: questionId,
                    option_id: optionId
                })
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (!data.success) {
                    alert(data.error || 'Une erreur est survenue lors de la validation.');
                    btn.disabled = false;
                    btn.textContent = '✓ Valider ma réponse';
                    return;
                }

                // --- SÉCURITÉ PÉDAGOGIQUE : VERROUILLAGE IRREVOCABLE ---
                // 1. Désactiver tous les radios de cette question
                questionStep.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                    radio.disabled = true;
                });
                questionStep.querySelectorAll('.proposal-card').forEach(function (card) {
                    card.style.pointerEvents = 'none';
                    card.classList.add('locked');
                });

                // 2. Masquer la barre d'action de validation initiale
                const actionBar = document.getElementById('action-validate-' + questionId);
                if (actionBar) {
                    actionBar.style.display = 'none';
                }

                // 3. Coloration des réponses :
                // - L'option sélectionnée par l'utilisateur
                const selectedPropCard = document.getElementById('prop-card-' + data.selected_option_id);
                // - La vraie bonne réponse
                const correctPropCard = document.getElementById('prop-card-' + data.correct_option_id);

                if (data.is_correct) {
                    if (selectedPropCard) {
                        selectedPropCard.classList.remove('selected');
                        selectedPropCard.classList.add('option-correct');
                    }
                } else {
                    if (selectedPropCard) {
                        selectedPropCard.classList.remove('selected');
                        selectedPropCard.classList.add('option-incorrect');
                    }
                    if (correctPropCard) {
                        correctPropCard.classList.add('option-correct');
                    }
                }

                // 4. Remplissage de la bannière de feedback
                const banner = document.getElementById('banner-' + questionId);
                const icon = document.getElementById('icon-' + questionId);
                const title = document.getElementById('status-title-' + questionId);
                const desc = document.getElementById('status-desc-' + questionId);

                if (banner && icon && title && desc) {
                    if (data.is_correct) {
                        banner.className = 'feedback-banner banner-correct';
                        icon.textContent = '✓';
                        title.textContent = 'Excellente réponse !';
                        desc.textContent = 'Bravo, vous avez remporté ' + data.points_gagnes + ' point pour cette question.';
                    } else {
                        banner.className = 'feedback-banner banner-incorrect';
                        icon.textContent = '✕';
                        title.textContent = 'Réponse incorrecte';
                        desc.textContent = 'Observez la bonne proposition signalée en vert ci-dessus et consultez l\'explication ci-dessous.';
                    }
                }

                // 5. Remplissage de l'explication pédagogique
                const expBox = document.getElementById('explanation-text-' + questionId);
                if (expBox) {
                    expBox.innerHTML = '<p>' + escapeHtml(data.explication) + '</p>';
                }

                // 6. Révélation de la zone de feedback
                const feedbackZone = document.getElementById('feedback-zone-' + questionId);
                if (feedbackZone) {
                    feedbackZone.hidden = false;
                    feedbackZone.classList.add('animate-fade-in');
                }

                // 7. Mise à jour du score en temps réel
                if (currentScoreVal) {
                    currentScoreVal.textContent = data.current_score;
                    currentScoreVal.classList.add('score-pop');
                    setTimeout(() => currentScoreVal.classList.remove('score-pop'), 600);
                }
            })
            .catch(function (error) {
                console.error('Erreur validation :', error);
                alert('Erreur réseau lors de la validation de votre réponse.');
                btn.disabled = false;
                btn.textContent = '✓ Valider ma réponse';
            });
        });
    });

    // -------------------------------------------------------------------------
    // 3. Passage à la question suivante
    // -------------------------------------------------------------------------
    document.querySelectorAll('.btn-next-step').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const currentQid = parseInt(btn.dataset.currentQid, 10);
            const nextIndex = parseInt(btn.dataset.nextIndex, 10);

            // Masquer la question courante
            const currentStep = document.getElementById('question-step-' + currentQid);
            if (currentStep) {
                currentStep.classList.remove('active');
            }

            // Afficher la question suivante
            const allSteps = document.querySelectorAll('.question-step');
            if (allSteps[nextIndex - 1]) {
                allSteps[nextIndex - 1].classList.add('active');
                currentStepIndex = nextIndex;

                // Mise à jour de la barre de progression
                if (stepCurrent) stepCurrent.textContent = currentStepIndex;
                const pct = Math.round((currentStepIndex / totalQuestions) * 100);
                if (stepPct) stepPct.textContent = pct + '%';
                if (progressBar) progressBar.style.width = pct + '%';

                // Défilement fluide vers le haut de la question
                allSteps[nextIndex - 1].scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // -------------------------------------------------------------------------
    // 4. Clôture et finalisation du Quiz
    // -------------------------------------------------------------------------
    const finishBtn = document.getElementById('btn-finish-quiz');
    if (finishBtn) {
        finishBtn.addEventListener('click', function () {
            finishBtn.disabled = true;
            finishBtn.textContent = 'Enregistrement de vos résultats en cours...';

            fetch(finishUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success && data.redirect_url) {
                    window.location.href = data.redirect_url;
                } else {
                    alert(data.error || 'Erreur lors de la clôture du quiz.');
                    finishBtn.disabled = false;
                    finishBtn.textContent = '🎯 Terminer le quiz & voir mon bilan &rarr;';
                }
            })
            .catch(function (error) {
                console.error('Erreur clôture quiz :', error);
                alert('Erreur réseau lors de l\'enregistrement de vos résultats.');
                finishBtn.disabled = false;
                finishBtn.textContent = '🎯 Terminer le quiz & voir mon bilan &rarr;';
            });
        });
    }

    /**
     * Échappe le texte pour éviter l'injection XSS côté client
     */
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

