# Parcours d'Onboarding — Speech English

---

## Objectif du Parcours

L'onboarding de **Speech English** a pour but d'amener un nouvel apprenant de la découverte du site jusqu'à la réussite de sa première leçon et de son premier quiz en **moins de 10 minutes**, tout en visualisant immédiatement ses progrès sur son tableau de bord.

---

## Déroulement du Parcours en 10 Étapes

```
[1. Accueil] ──> [2. Découverte] ──> [3. Inscription] ──> [4. Connexion] ──> [5. Dashboard]
                                                                                   │
[10. Progression] <── [9. Score] <── [8. Premier Quiz] <── [7. 1re Leçon] <── [6. Choix Niveau]
```

---

### 1. Arrivée sur la page d'accueil
* **Écran affiché :** Page d'accueil (*Hero section*), titre accrocheur (*« Master English grammar, step by step »*), aperçu visuel des trois niveaux et bouton principal **« Commencer »**.
* **Action utilisateur :** Arrive sur le site et prend connaissance de la promesse pédagogique.
* **Réaction de l'application :** Affichage rapide et épuré des éléments clés au-dessus de la ligne de flottaison.
* **Objectif UX :** Capter l'intérêt en moins de 5 secondes et rassurer sur l'accessibilité du service.

---

### 2. Découverte de Speech English
* **Écran affiché :** Section de présentation de la méthode (*Comprendre, Pratiquer, Mesurer*) et des 3 parcours (Easy, Basic, Hard).
* **Action utilisateur :** Fait défiler la page pour vérifier si le contenu correspond à son niveau et à ses besoins.
* **Réaction de l'application :** Présentation visuelle claire avec codes couleurs distinctifs (*Teal*, *Gold*, *Red*).
* **Objectif UX :** Lever les doutes de l'apprenant non natif et susciter l'envie de s'inscrire.

---

### 3. Inscription
* **Écran affiché :** Formulaire d'inscription simple (nom, prénom, email, mot de passe).
* **Action utilisateur :** Renseigne les quatre champs obligatoires et clique sur **« Créer mon compte »**.
* **Réaction de l'application :** Validation instantanée des données, hachage sécurisé du mot de passe et création du compte en base de données.
* **Objectif UX :** Réduire la friction à l'entrée avec un formulaire rempli en moins d'une minute.

---

### 4. Connexion
* **Écran affiché :** Écran de connexion (ou connexion automatique suite à l'inscription).
* **Action utilisateur :** Saisit ses identifiants et valide.
* **Réaction de l'application :** Vérification des accès en PHP/PDO, initialisation de la session (`$_SESSION`) et redirection directe.
* **Objectif UX :** Assurer une transition fluide et sécurisée vers l'espace personnel.

---

### 5. Accès au tableau de bord
* **Écran affiché :** Tableau de bord apprenant personnalisé (*« Bienvenue, [Prénom] ! »*), barre de progression à 0 % et bouton d'action mis en valeur : **« Choisir mon niveau »**.
* **Action utilisateur :** Découvre son espace de travail et clique sur le bouton d'action.
* **Réaction de l'application :** Affichage d'une interface épurée orientant directement vers l'étape suivante.
* **Objectif UX :** Éviter toute sensation de surcharge en guidant immédiatement vers l'action utile.

---

### 6. Découverte des trois niveaux
* **Écran affiché :** Page des parcours présentant trois cartes distinctes :
  * **Easy** (Débutant · Temps simples)
  * **Basic** (Intermédiaire · Perfect & Continuous)
  * **Hard** (Avancé · Phrasal verbs & Passive)
* **Action utilisateur :** Choisit son niveau de départ (ex. *Easy*).
* **Réaction de l'application :** Ouverture immédiate du programme des leçons du niveau retenu.
* **Objectif UX :** Laisser le libre choix à l'utilisateur sans test éliminatoire bloquant.

---

### 7. Consultation de la première leçon
* **Écran affiché :** Fiche de cours claire et courte (ex. *Present Simple*) : règle essentielle, formule syntaxique, exemples bilingues mis en valeur et bouton **« Passer au quiz »**.
* **Action utilisateur :** Lit la règle (2 à 3 minutes) et lance l'évaluation.
* **Réaction de l'application :** Affichage optimisé pour la lecture, centré sur le texte sans éléments perturbateurs.
* **Objectif UX :** Privilégier le *micro-learning* : peu de théorie, immédiatement applicable.

---

### 8. Réalisation du premier quiz
* **Écran affiché :** Interface de quiz interactive (ex. question 1/5, énoncé, choix multiples sous forme de grands boutons tactiles).
* **Action utilisateur :** Sélectionne sa réponse et progresse question par question.
* **Réaction de l'application :** Transition dynamique en JavaScript entre les questions et calcul du résultat à la soumission.
* **Objectif UX :** Rendre l'évaluation stimulante, rapide et ergonomique sur smartphone.

---

### 9. Affichage du premier score
* **Écran affiché :** Écran de résultat affichant la note (ex. 80 % - 4/5), un message encourageant et le corrigé détaillé (vert pour correct, rouge avec explication si erreur).
* **Action utilisateur :** Analyse ses réponses et clique sur **« Voir ma progression »**.
* **Réaction de l'application :** Enregistrement de la tentative en BDD MySQL et affichage instantané du bilan.
* **Objectif UX :** Fournir un retour valorisant immédiat et dédramatiser l'erreur grâce à l'explication.

---

### 10. Découverte de la progression
* **Écran affiché :** Tableau de bord actualisé avec la jauge d'avancement incrémentée, la première leçon marquée comme validée et l'historique du quiz enregistré.
* **Action utilisateur :** Constate son premier progrès concret et identifie la leçon suivante suggérée.
* **Réaction de l'application :** Recalcul en temps réel de la progression globale et mise en avant de la suite du parcours.
* **Objectif UX :** Clore la boucle d'onboarding sur un sentiment d'accomplissement et installer une habitude d'apprentissage.

---

## Comment Réduire les Difficultés du Nouvel Utilisateur ?

Afin d'éviter les abandons lors des premières minutes d'utilisation, Speech English applique cinq principes ergonomiques ciblés :

| Principe | Problème évité | Solution mise en œuvre |
| :--- | :--- | :--- |
| **Inscription minimaliste** | Abandon lié à un formulaire trop long. | 4 champs seulement (nom, prénom, email, mot de passe), sans validation d'email bloquante pour démarrer. |
| **Un seul bouton d'action par écran** | Hésitation sur l'action à mener (*« Que dois-je faire maintenant ? »*). | Mise en avant d'un bouton d'action primaire (*Call-to-Action*) unique et contrasté à chaque étape. |
| **Leçons courtes (*Micro-learning*)** | Découragement face à des cours théoriques denses. | Fiches de cours synthétiques lisibles en moins de 3 minutes avec focus sur les exemples concrets. |
| **Feedback positif et immédiat** | Frustration ou sentiment d'échec lors d'une mauvaise réponse au quiz. | Correction instantanée en couleur avec explication bienveillante de la règle pour chaque erreur. |
| **Conception Mobile-First** | Inconfort d'usage sur téléphone. | Boutons larges manipulables au pouce, typographie lisible (Georgia / Calibri) et adaptation fluide à tous les écrans. |

