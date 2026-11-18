# Compte-Rendu de Réunion de Kick-Off — Projet Speech English

---

## Informations Générales sur la Réunion

| Propriété | Détail |
| :--- | :--- |
| **Intitulé du projet** | **Speech English** |
| **Cadre du projet** | TD de Fondamentaux du Web — MIAGE 2ème année |
| **Type de réunion** | Réunion de lancement (Kick-Off Meeting) |
| **Date de la réunion** | [À COMPLÉTER : JJ/MM/AAAA] |
| **Horaires** | [À COMPLÉTER : Début - Fin, ex. 14h00 - 15h30] |
| **Lieu / Format** | [À COMPLÉTER : ex. Salle de TD / Visioconférence Discord / Teams] |
| **Rédacteur du compte-rendu** | [À COMPLÉTER : Nom et Prénom] |
| **Version du document** | 1.0 |
| **Statut** | Validé par l'équipe |

### Équipe projet et émargement

| Rôle | Membre assigné | Statut de présence |
| :--- | :--- | :---: |
| **Chef de projet** | [À COMPLÉTER : Nom et Prénom] | Présent |
| **Responsable UX/UI et conception** | [À COMPLÉTER : Nom et Prénom] | Présent |
| **Développeur frontend** | [À COMPLÉTER : Nom et Prénom] | Présent |
| **Développeur backend et base de données** | [À COMPLÉTER : Nom et Prénom] | Présent |

---

## 1. Date et objectif de la réunion

La réunion de lancement s'est tenue le **[À COMPLÉTER : Date]** avec pour vocation d'officialiser le démarrage du projet **Speech English** dans le cadre du module *Fondamentaux du Web* en MIAGE 2ème année.

### Ordre du jour et objectifs de la séance :
1. Présenter la vision générale du projet, la problématique ciblée et la proposition de valeur.
2. Aligner l'équipe sur les objectifs pédagogiques et académiques à atteindre.
3. Attribuer officiellement les responsabilités de chacun des quatre membres.
4. Établir le planning prévisionnel et les grands jalons de livraison.
5. Définir les protocoles de communication interne et les outils collaboratifs.
6. Arrêter la méthode de gestion de versions avec Git et GitHub.
7. Inventorier les premiers risques opérationnels et entériner les décisions structurantes.

---

## 2. Présentation du projet

### 2.1 Synthèse de l'application
**Speech English** est une application web d'apprentissage de l'anglais principalement axée sur la **maîtrise progressive de la grammaire**. 

Face aux difficultés récurrentes rencontrées par les personnes non natives (appréhension de la prise de parole, manque de confiance, méconnaissance des structures de conjugaison), l'application propose un parcours d'apprentissage découpé en trois niveaux d'acquisition :
* **Easy (Débutant / Primary) :** Fondamentaux des temps simples (*Present Simple*, *Past Simple*, *Future Simple*).
* **Basic (Intermédiaire / College) :** Maîtrise des aspects et nuances temporelles (*Present Perfect*, *Past Perfect*, *Present Continuous*, *Past Continuous*).
* **Hard (Avancé / High School & Pro) :** Structures complexes (*Phrasal Verbs*, voix active/passive, expressions de dialogue et discours rapporté).

### 2.2 Périmètre du MVP validé en séance
L'équipe s'accorde sur un périmètre restreint et robuste pour le MVP (Minimum Viable Product) :
* Gestion des comptes apprenants (inscription, connexion/déconnexion sécurisée via sessions PHP).
* Tableau de bord personnel visualisant le profil, le niveau actuel, le résumé des scores et la progression.
* Sélecteur interactif des trois niveaux d'apprentissage.
* Consultation de fiches de cours synthétiques accompagnées d'exemples concrets.
* Moteur de quiz interactif avec correction automatique instantanée.
* Enregistrement en base de données de chaque tentative et affichage de l'historique complet des résultats.

---

## 3. Objectifs de l'équipe

L'équipe s'est fixé une double exigence d'excellence académique et de rigueur technique :

### 3.1 Objectifs académiques
* Satisfaire l'intégralité du cahier des charges et des attendus du TD de Fondamentaux du Web en MIAGE 2ème année.
* Démontrer une mise en œuvre propre et maîtrisée des technologies web fondamentales sans framework tiers obligatoire.
* Présenter une soutenance fluide, étayée par une démonstration en direct (*live demo*) sans anomalie bloquante.

### 3.2 Objectifs techniques et qualitatifs
* **Modularité et lisibilité :** Produire un code propre, indenté, commenté et conforme aux standards W3C (HTML5/CSS3) et aux recommandations PHP-FIG (PSR).
* **Sécurité native :** Appliquer systématiquement les bonnes pratiques de sécurité web (requêtes préparées PDO contre les injections SQL, hachage bcrypt/argon2 via `password_hash()`, protection contre les failles XSS via `htmlspecialchars()`).
* **Ergonomie Mobile-First :** Fournir une interface 100 % adaptative, testée et agréable à manipuler sur terminal mobile comme sur grand écran.

---

## 4. Répartition des responsabilités

Afin de fluidifier le travail d'équipe et d'éviter les zones de flou ou de doublon, chaque membre se voit confier un rôle pivot :

```
                                CHEF DE PROJET
                         [À COMPLÉTER : Nom & Prénom]
                        Coordination, Planning, Suivi
                                      │
        ┌─────────────────────────────┼─────────────────────────────┐
        ▼                             ▼                             ▼
RESPONSABLE UX/UI            DÉVELOPPEUR FRONTEND          DÉVELOPPEUR BACKEND & BDD
[À COMPLÉTER : Nom]           [À COMPLÉTER : Nom]             [À COMPLÉTER : Nom]
Charte, Wireframes,           Intégration HTML/CSS,        Architecture PHP, Sessions,
Maquettes & Ergonomie         Interactivité JS & Quiz        Schéma MySQL & Sécurité
```

### 4.1 Fiches de rôles détaillées

#### Chef de projet
* **Titulaire :** [À COMPLÉTER : Nom et Prénom]
* **Périmètre d'action :**
  * Coordination globale de l'équipe et tenue du planning prévisionnel.
  * Animation des réunions hebdomadaires et rédaction des comptes-rendus.
  * Suivi de l'avancement des tâches et déblocage des points d'achoppement.
  * Gestion des livrables documentaires et préparation de la soutenance finale.

#### Responsable UX/UI et conception
* **Titulaire :** [À COMPLÉTER : Nom et Prénom]
* **Périmètre d'action :**
  * Élaboration de la charte graphique (palette chromatique Navy/Red/Teal/Gold/Cream, typographies Georgia/Calibri).
  * Conception des wireframes basse fidélité et des maquettes UI haute fidélité (desktop et mobile).
  * Modélisation du parcours utilisateur (*User Journey*) et optimisation de l'onboarding.
  * Veille ergonomique, utilisabilité au pouce et respect des contrastes d'accessibilité.

#### Développeur frontend
* **Titulaire :** [À COMPLÉTER : Nom et Prénom]
* **Périmètre d'action :**
  * Intégration sémantique HTML5 et stylisation responsive CSS3 (Grid & Flexbox).
  * Développement des composants interactifs en JavaScript Vanilla (dynamisme des formulaires, carrousels de leçons, animations d'interface).
  * Développement du moteur de quiz côté client (défilement des questions, affichage dynamique des options et restitution du feedback couleur vert/rouge).

#### Développeur backend et base de données
* **Titulaire :** [À COMPLÉTER : Nom et Prénom]
* **Périmètre d'action :**
  * Modélisation et implémentation du schéma relationnel MySQL (MCD/MLD, scripts `schema.sql` et `seed.sql`).
  * Développement de l'architecture serveur en PHP 8 (gestion des formulaires, sessions utilisateur, contrôle d'accès).
  * Implémentation de la logique de correction automatique des quiz et de l'enregistrement des scores.
  * Sécurisation des accès aux données (PDO, requêtes préparées, filtrage des entrées/sorties).

### 4.2 Matrice RACI des livrables

*Légende : **R** = Réalisateur (Responsible), **A** = Approbateur (Accountable), **C** = Consulté (Consulted), **I** = Informé (Informed)*

| Livrable / Tâche majeure | Chef de projet | Resp. UX/UI | Dév. Frontend | Dév. Backend & BDD |
| :--- | :---: | :---: | :---: | :---: |
| Note de cadrage & Kick-off | **R / A** | C | C | C |
| Charte graphique & Maquettes UI | C | **R / A** | C | I |
| Modèle de données & Schéma SQL | C | I | C | **R / A** |
| Starter kit & Configuration XAMPP | C | I | **R** | **R / A** |
| Intégration des vues HTML/CSS | I | C | **R / A** | C |
| Scripts PHP (Auth, Sessions, Routage) | I | I | C | **R / A** |
| Moteur de quiz & Évaluation JS/PHP | C | C | **R** | **R / A** |
| Tests d'intégration & Recette | **A** | R | R | R |
| Support de soutenance & Démo | **R / A** | R | R | R |

---

## 5. Planning prévisionnel

Le projet s'échelonne sur un cycle indicatif de 6 semaines conformément au calendrier universitaire du TD :

| Période | Étape / Sprint | Objectifs et livrables associés | Responsable principal |
| :---: | :--- | :--- | :--- |
| **Semaine 1**<br>`[À COMPLÉTER : Dates]` | **Cadrage & Lancement** | Finalisation de la note de cadrage, réunion de kick-off, validation du périmètre MVP et initialisation du dépôt Git. | Chef de projet |
| **Semaine 2**<br>`[À COMPLÉTER : Dates]` | **Conception UX/UI & Modélisation** | Réalisation de la charte graphique, des wireframes/maquettes, et modélisation du schéma de la BDD (`schema.sql`). | Resp. UX/UI & Dév. Backend |
| **Semaine 3**<br>`[À COMPLÉTER : Dates]` | **Architecture & Starter Kit** | Configuration de l'environnement XAMPP, création des tables SQL de test (`seed.sql`), intégration du layout global HTML/CSS. | Dév. Frontend & Backend |
| **Semaine 4**<br>`[À COMPLÉTER : Dates]` | **Développement MVP (Lot 1)** | Implémentation de l'inscription/connexion (sessions PHP), du tableau de bord apprenant et de la navigation des leçons. | Dév. Backend & Frontend |
| **Semaine 5**<br>`[À COMPLÉTER : Dates]` | **Développement MVP (Lot 2)** | Développement complet du moteur de quiz, algorithme de correction instantanée, calcul et historisation des scores. | Dév. Frontend & Backend |
| **Semaine 6**<br>`[À COMPLÉTER : Dates]` | **Recette, Tests & Soutenance** | Phase de tests croisés, correction des bugs, finalisation de la documentation technique et répétition de la soutenance. | Toute l'équipe |

### Jalons critiques (Milestones)
* **Jalon 1 — [À COMPLÉTER : Date] :** Validation conjointe de la charte graphique et du schéma SQL.
* **Jalon 2 — [À COMPLÉTER : Date] :** Validation du module d'authentification et de session fonctionnel sous XAMPP.
* **Jalon 3 — [À COMPLÉTER : Date] :** Gel des fonctionnalités du MVP (*Feature Freeze*) et passage complet du premier quiz.
* **Jalon 4 — [À COMPLÉTER : Date] :** Soutenance finale du projet devant les enseignants du TD.

---

## 6. Méthode de communication

Pour garantir un niveau d'information homogène et anticiper tout retard, l'équipe adopte les principes de communication suivants :

### 6.1 Canaux officiels
* **Messagerie instantanée :** [À COMPLÉTER : ex. Serveur Discord dédié / Groupe WhatsApp / Slack].
  * Canal `#général` : Annonces formelles, liens de partage et synthèses.
  * Canal `#technique` : Questions relatives à Git, PHP, MySQL, CSS et résolution de bugs.
  * Canal `#design` : Partage des wireframes, maquettes et retours visuels.
* **Partage documentaire & suivi :** [À COMPLÉTER : ex. Dépôt GitHub / Notion / Trello / Google Drive].

### 6.2 Rituels d'équipe
* **Point hebdomadaire synchrone :** Chaque **[À COMPLÉTER : Jour de la semaine, ex. Lundi à 18h00]** d'une durée de 30 à 45 minutes pour passer en revue les tâches terminées et fixer les priorités du sprint.
* **Stand-up asynchrone régulier :** Chaque membre publie deux fois par semaine un message court répondant à trois questions :
  1. *Qu'ai-je finalisé depuis le dernier point ?*
  2. *Sur quoi vais-je travailler d'ici le prochain point ?*
  3. *Ai-je un point bloquant nécessitant l'aide d'un coéquipier ?*
* **Règle de réactivité :** Tout membre sollicité sur les canaux s'engage à accuser réception ou à répondre dans un délai maximal de **24 heures**.

---

## 7. Outils de travail

L'équipe a sélectionné une suite d'outils cohérente, gratuite et parfaitement alignée avec les contraintes académiques :

| Catégorie | Outil retenu | Rôle dans le projet |
| :--- | :--- | :--- |
| **Environnement local** | **XAMPP (Apache, PHP 8, MariaDB)** | Hébergement et exécution du serveur web et de la base de données en local. |
| **Gestionnaire de BDD** | **phpMyAdmin** (inclus XAMPP) | Administration graphique des tables, exécution des scripts SQL et vérification des données. |
| **Éditeur de code (IDE)** | [À COMPLÉTER : ex. VS Code / Antigravity / PhpStorm] | Environnement de développement avec extensions recommandées (PHP Intelephense, Prettier). |
| **Gestion des versions** | **Git & GitHub** | Traçabilité du code, travail collaboratif, revues de code et historique des versions. |
| **Conception UI/UX** | [À COMPLÉTER : ex. Figma / Penpot] | Élaboration de la charte graphique, conception des wireframes et prototypes interactifs. |
| **Suivi des tâches** | [À COMPLÉTER : ex. GitHub Projects / Trello / Notion] | Gestion du tableau Kanban (À faire, En cours, En revue, Terminé). |
| **Navigateurs de test** | **Google Chrome & Mozilla Firefox** | Tests d'affichage, émulation multi-écrans et débogage console/réseau via les DevTools. |

---

## 8. Méthode de gestion des versions avec Git et GitHub

Pour éviter toute écrasement de code ou conflit bloquant, une discipline stricte de gestion de version est instaurée dès le premier jour :

### 8.1 Répertoire et organisation
* **Dépôt GitHub officiel :** `[À COMPLÉTER : URL du repository GitHub]`
* **Fichier `.gitignore` :** Mise en place d'un fichier standard pour exclure les fichiers temporaires de l'OS (`.DS_Store`, `Thumbs.db`), les dossiers d'éditeurs (`.vscode/`, `.idea/`) et les identifiants locaux sensibles.

### 8.2 Stratégie de branches (Git Flow simplifié)

```
main       ────────────────────────────────────────● (v1.0 Soutenance)
               ▲                                   ▲
develop    ────┼────────●─────────────────●────────┼─── (Intégration continue)
                   ▲         ▲        ▲        ▲
feature/*          └─── auth ┘        └── quiz ┘        (Développement isolé)
```

1. **Branche `main` :** Branche de production réservée aux versions stables et testées. Aucun commit direct n'est toléré sur `main`.
2. **Branche `develop` :** Branche centrale de travail regroupant l'ensemble des fonctionnalités validées.
3. **Branches secondaires (`feature/<nom>` ou `fix/<nom>`) :** Chaque fonctionnalité ou correction est développée sur une branche dédiée dérivée de `develop`.
   * *Exemples de branches conventionnelles :*
     * `feature/auth-sessions`
     * `feature/ui-dashboard`
     * `feature/quiz-engine`
     * `feature/lessons-display`
     * `fix/score-calculation`

### 8.3 Norme de rédaction des messages de commit
Les commits doivent impérativement respecter la norme des *Conventional Commits* en minuscules avec description claire :
* `feat: ...` pour l'ajout d'une nouvelle fonctionnalité.
* `fix: ...` pour la correction d'une anomalie.
* `style: ...` pour les modifications de mise en forme CSS ou d'affichage sans changement de logique.
* `docs: ...` pour les ajouts ou mises à jour de documentation.
* `refactor: ...` pour la réorganisation de code sans modification fonctionnelle.

### 8.4 Processus de Pull Request (PR) et revue de code
* Aucun merge direct vers `develop` ou `main`.
* Toute branche terminée fait l'objet d'une **Pull Request** sur GitHub.
* La PR doit être relue, testée et approuvée par **au moins un autre membre de l'équipe** avant fusion.
* La branche fonctionnelle est ensuite supprimée pour maintenir un dépôt propre.

---

## 9. Risques identifiés

L'équipe a procédé à une analyse préliminaire des risques susceptibles d'impacter le bon déroulement du projet :

| Risque | Probabilité | Gravité | Mesure de prévention / Solution retenue |
| :--- | :---: | :---: | :--- |
| **Conflits de fusion Git sur les mêmes fichiers** | Élevée | Moyenne | Découpage strict des fichiers front/back ; synchronisation quotidienne (`git pull origin develop`) ; communication avant toute modification de structure partagée. |
| **Divergence entre structure des formulaires (Front) et traitement PHP (Back)** | Moyenne | Élevée | Rédaction conjointe et préalable d'un tableau des paramètres (`name`, types de données, méthodes `POST`) avant le début des développements respectifs. |
| **Sous-estimation de la charge de travail / Retard de planning** | Moyenne | Élevée | Sanctuarisation du périmètre MVP ; exclusion ferme des fonctionnalités v2 ; suivi hebdomadaire rigoureux des jalons. |
| **Problèmes d'environnement local hétérogène sous XAMPP** | Faible | Moyenne | Harmonisation de la version PHP minimale requise (PHP 8.1+) et centralisation des paramètres de connexion BDD dans un fichier unique `config/db.php`. |
| **Vulnérabilités de sécurité web (Injections SQL, failles XSS)** | Moyenne | Élevée | Recours obligatoire aux requêtes préparées via PDO et au filtrage des sorties avec `htmlspecialchars()`. Revue de code systématique avant validation de PR. |

---

## 10. Décisions prises

Au terme de cette réunion de lancement, les résolutions suivantes ont été adoptées à l'unanimité :

1. **Intitulé et positionnement :** L'application s'appelle officiellement **Speech English** et se concentre sur l'apprentissage progressif de la grammaire anglaise en 3 paliers (*Easy*, *Basic*, *Hard*).
2. **Architecture technique :** La stack officielle est confirmée : **HTML5, CSS3, JavaScript Vanilla, PHP 8.x, MySQL/MariaDB sous environnement XAMPP**.
3. **Périmètre du MVP :** Validation du parcours complet utilisateur (inscription/connexion -> dashboard -> choix niveau -> consultation leçon -> passation de quiz -> correction instantanée -> enregistrement historique et progression). Report de toutes les options annexes (audio, gamification complexe, etc.) aux versions futures.
4. **Attribution des rôles :** Répartition officielle des 4 rôles (Chef de projet, UX/UI, Développeur frontend, Développeur backend/BDD).
5. **Gestion de version :** Adoption de GitHub avec flux de travail `main` / `develop` / `feature/*` et revue de code obligatoire par un tiers avant fusion.
6. **Livrables immédiats pour le sprint suivant :**
   * Le Chef de projet consolide la documentation initiale.
   * Le Responsable UX/UI finalise les wireframes des écrans clés.
   * Le Développeur Backend produit le script de création de BDD `schema.sql`.
   * Le Développeur Frontend prépare le squelette de l'interface et la feuille de style commune.
7. **Prochaine réunion d'équipe fixée :**
   * **Date :** [À COMPLÉTER : Date du prochain point d'étape]
   * **Heure :** [À COMPLÉTER : Heure]
   * **Ordre du jour :** Validation des maquettes UI et du schéma relationnel MySQL.

