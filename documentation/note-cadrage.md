# Note de Cadrage — Projet Speech English

---

## Informations Générales sur le Document

| Propriété | Détail |
| :--- | :--- |
| **Nom du projet** | **Speech English** |
| **Type de projet** | Application web éducative (E-learning / EdTech) |
| **Axe d'apprentissage** | Grammaire anglaise progressive (3 niveaux) |
| **Stack technique retenue** | HTML5, CSS3, JavaScript (ES6+), PHP 8.x, MySQL (MariaDB), XAMPP |
| **Document** | Note de cadrage de projet (Définition préalable au développement) |
| **Statut du projet** | Phase de cadrage et de conception (Avant-projet) |
| **Version du document** | 1.0 |
| **Date d'élaboration** | Novembre 2026 |

---

## 1. Présentation du projet

**Speech English** est un projet d'application web interactive dédiée à l'apprentissage et au perfectionnement de la langue anglaise, principalement axée sur la **maîtrise de la grammaire**.

L'application a pour vocation d'offrir une alternative claire, progressive et stimulante aux méthodes traditionnelles d'apprentissage grammatical, souvent perçues comme trop abstraites ou rébarbatives. En structurant l'apprentissage autour de trois paliers d'évolution cohérents — **Easy** (débutant), **Basic** (intermédiaire) et **Hard** (avancé) —, Speech English propose un écosystème numérique où chaque apprenant progresse à son rythme à travers des leçons synthétiques, des exercices pratiques et des quiz interactifs dotés d'une correction instantanée et d'un suivi analytique des résultats.

Le projet est conçu pour être développé et exécuté localement au moyen d'un environnement standardisé **XAMPP** (Apache, MySQL/MariaDB, PHP), en s'appuyant sur les technologies fondamentales du web (**HTML5, CSS3, JavaScript**).

---

## 2. Contexte et problématique

### 2.1 Contexte général
Dans un environnement académique et professionnel de plus en plus globalisé, la maîtrise de l'anglais s'impose comme une compétence incontournable, conditionnant l'accès aux études supérieures, à la mobilité internationale et à de nombreuses opportunités de carrière.

Néanmoins, pour un large public non natif (notamment francophone), l'anglais demeure une source d'appréhension. Une majorité d'apprenants n'osent pas s'exprimer ou doutent constamment de leur formulation en raison d'une mauvaise maîtrise des règles grammaticales, de la conjugaison des temps et de la structure des phrases.

### 2.2 Problématique centrale
Face à ce constat, le projet Speech English répond à la problématique suivante :

> **« Comment permettre à des apprenants non natifs de surmonter leurs blocages en grammaire anglaise et de progresser en toute autonomie grâce à une application web progressive, ergonomique et motivante ? »**

### 2.3 Freins identifiés chez les apprenants
* **La complexité perçue de la grammaire :** Manque d'explications concrètes reliant la règle grammaticale à des situations de communication courantes.
* **Le manque de feedback immédiat :** Dans un apprentissage sur support papier ou passif, l'apprenant ne sait pas immédiatement où se situent ses erreurs, ce qui favorise l'ancrage de mauvaises habitudes syntaxiques.
* **L'absence de lisibilité des progrès :** Sans suivi chiffré de son parcours, l'apprenant perd rapidement sa motivation initiale.

---

## 3. Besoin identifié

Le projet répond à un ensemble de besoins pédagogiques, ergonomiques et techniques précis, formalisés ci-dessous :

### 3.1 Besoins pédagogiques
* **Besoin de progressivité balisée :** L'apprenant a besoin d'étapes d'apprentissage clairement délimitées pour ne pas être confronté à des notions trop complexes avant d'avoir assimilé les fondamentaux.
* **Besoin de synthèses digestes :** Les règles doivent être courtes, directes, accompagnées d'exemples bilingues et d'astuces mnémotechniques simples.
* **Besoin de mise en pratique active :** La théorie doit être validée sans attendre par des exercices courts et des quiz d'évaluation.

### 3.2 Besoins utilisateurs (UX)
* **Feedback instantané :** Connaître son score immédiatement après avoir répondu et identifier précisément la réponse attendue et la justification de l'erreur.
* **Traçabilité et autonomie :** Pouvoir consulter son historique de scores, mesurer sa progression globale et reprendre ses révisions là où il s'était arrêté.
* **Fluidité d'accès :** Interface épurée, réactive, fonctionnant parfaitement sur ordinateur comme sur smartphone.

### 3.3 Besoins techniques
* **Persistance sécurisée des données :** Stocker de façon intègre les comptes utilisateurs, leurs scores, l'historique de passage des quiz et le statut d'avancement des leçons.
* **Déploiement local accessible :** Fonctionnement optimal sous la suite logicielle XAMPP sans nécessiter de chaîne de build complexe ou d'outillage lourd.

---

## 4. Objectifs généraux et spécifiques

### 4.1 Objectifs généraux
1. Concevoir et développer une application web dynamique favorisant l'apprentissage autonome et structuré de la grammaire anglaise.
2. Démystifier les règles de grammaire auprès des apprenants non natifs via une méthode en trois niveaux progressifs.
3. Proposer une solution logicielle robuste, responsive et sécurisée reposant sur une architecture PHP / MySQL éprouvée.

### 4.2 Objectifs spécifiques (SMART)

| Axe | Objectif Spécifique | Indicateur de Réussite |
| :--- | :--- | :--- |
| **Pédagogique** | Intégrer au moins **3 parcours complets** (Easy, Basic, Hard) contenant chacun des fiches de cours et des séries de quiz ciblés. | Au moins 9 à 12 leçons thématiques et quiz associés disponibles au MVP. |
| **Ergonomique** | Réduire au strict minimum les étapes entre l'inscription et la première évaluation. | Un nouvel utilisateur doit pouvoir créer son compte et lancer son premier quiz en **moins de 2 minutes**. |
| **Technique** | Assurer une exécution fluide et rapide de l'application sous serveur local Apache / PHP 8. | Temps de réponse moyen des pages et des soumissions de quiz **inférieur à 500 ms** en local. |
| **Sécurité** | Protéger les données utilisateurs et sécuriser les interactions avec la base de données MySQL. | 100 % des requêtes SQL préparées via PDO ; mots de passe systématiquement hachés avec `password_hash()`. |
| **Compatibilité** | Offrir une interface entièrement adaptative (Responsive Web Design). | Affichage et fonctionnalités 100 % opérationnels sur mobile, tablette et écran desktop. |

---

## 5. Public cible

L'application s'adresse à un public large désireux d'acquérir, de réviser ou de perfectionner ses compétences en anglais. Trois segments principaux sont ciblés :

```
                                  PUBLICS CIBLES
                                         │
        ┌────────────────────────────────┼────────────────────────────────┐
        ▼                                ▼                                ▼
  NIVEAU DÉBUTANT                NIVEAU INTERMÉDIAIRE               NIVEAU AVANCÉ
   (Niveau Easy)                    (Niveau Basic)                  (Niveau Hard)
Élèves de primaire, collégiens,  Lycéens, étudiants d'université    Professionnels, adultes en
grands débutants sans bases.     préparant des examens académiques. reconversion, candidats aux tests.
```

### 5.1 Personas types

#### Persona 1 : L'Apprenant Débutant (Niveau Easy)
* **Profil :** Lucas, 14 ans, élève de 4e.
* **Problème :** Confond le *Present Simple* et le *Past Simple*, perd confiance lors des évaluations scolaires.
* **Attente :** Des leçons concises avec des exemples concrets de la vie quotidienne et des quiz courts sur smartphone pour s'entraîner 10 minutes par jour.

#### Persona 2 : L'Étudiante Intermédiaire (Niveau Basic)
* **Profil :** Sarah, 20 ans, étudiante en licence universitaire.
* **Problème :** Hésite systématiquement entre le *Present Perfect* et le *Past Simple*, a du mal à manier les formes continues.
* **Attente :** Des explications contrastives claires, des exercices corrigés instantanément et un tableau de bord indiquant ses progrès notion par notion.

#### Persona 3 : Le Professionnel / Candidat (Niveau Hard)
* **Profil :** Marc, 32 ans, cadre en entreprise préparant une certification ou des entretiens professionnels en anglais.
* **Problème :** Manque d'aisance dans l'usage des *phrasal verbs*, la voix passive et le discours rapporté dans ses échanges formels.
* **Attente :** Un perfectionnement ciblé sur les structures complexes et idiomatiques avec consultation de son historique de scores.

---

## 6. Solution proposée

### 6.1 Concept pédagogique : Le cycle en 4 étapes
La solution Speech English repose sur un parcours d'apprentissage séquentiel et itératif :

```
[ 1. Comprendre ] ──> [ 2. Pratiquer ] ──> [ 3. Corriger ] ──> [ 4. Mesurer ]
  Fiche de cours        Quiz interactif       Correction auto        Tableau de bord
  règles & exemples     QCM / phrases         détail & feed-back     scores & progression
```

### 6.2 Découpage des trois niveaux d'apprentissage

#### 1. Niveau Easy — Les Temps Simples (*Primary*)
* **Objectif :** Acquérir les bases fondamentales de la conjugaison et de la structure de phrase pour exprimer des faits, des habitudes et des événements passés ou futurs.
* **Notions clés prévues :**
  * *Present Simple* : Habitudes, vérités générales, règle du "-s" à la 3e personne du singulier (*« I study English every day »*).
  * *Past Simple* : Actions terminées et datées dans le passé, distinction verbes réguliers / irréguliers (*« Yesterday, I visited Paris »*).
  * *Future Simple* : Projets, prévisions et décisions spontanées avec *will* (*« Tomorrow, I will call you »*).

#### 2. Niveau Basic — Les Temps Composés et Formes Continues (*College*)
* **Objectif :** Maîtriser les aspects temporels (durée, continuité, antériorité et lien avec le présent).
* **Notions clés prévues :**
  * *Present Perfect* : Lien entre événement passé et situation présente, bilan (*« I have just finished my homework »*).
  * *Past Perfect* : Expression de l'antériorité par rapport à un repère passé (*« She had left before I arrived »*).
  * *Present Continuous* : Action en cours de déroulement au moment d'énonciation (*« I am studying right now »*).
  * *Past Continuous* : Action passée en cours de réalisation interrompue par une autre (*« I was watching TV when you called »*).

#### 3. Niveau Hard — Structures Avancées et Expression Naturelle (*High School & Pro*)
* **Objectif :** Maîtriser des structures syntaxiques complexes et s'approprier les subtilités de la langue anglaise authentique.
* **Notions clés prévues :**
  * *Phrasal Verbs* : Verbes à particule indispensables pour la fluidité lexicale (*give up, look forward to, run into*).
  * *Voix Active & Voix Passive* : Restructuration de la phrase pour mettre l'accent sur l'objet ou l'action (*« The lesson was explained by the teacher »*).
  * *Expressions de dialogue & Discours rapporté* : Passage du discours direct au discours indirect (*Reported Speech*) et formules conversationnelles avancées.

---

## 7. Fonctionnalités du MVP (Minimum Viable Product)

Le périmètre initial du produit se concentre sur les fonctionnalités indispensables pour garantir l'expérience d'apprentissage complète, depuis l'inscription jusqu'au suivi des scores.

### Matrice des fonctionnalités du MVP

| Module | Fonctionnalité | Description fonctionnelle | Priorité |
| :--- | :--- | :--- | :---: |
| **Authentification** | Création de compte | Formulaire d'inscription (nom, prénom, adresse email, mot de passe sécurisé). | **P0** (Critique) |
| **Authentification** | Connexion / Déconnexion | Authentification par email et mot de passe ; ouverture et fermeture de session PHP (`$_SESSION`). | **P0** (Critique) |
| **Authentification** | Contrôle d'accès | Restriction des pages réservées aux utilisateurs authentifiés ; redirection automatique vers la connexion. | **P0** (Critique) |
| **Tableau de bord** | Dashboard utilisateur | Affichage de l'identité de l'apprenant, du niveau en cours, du taux de progression et du résumé des derniers scores. | **P0** (Critique) |
| **Parcours & Niveaux** | Sélection de niveau | Interface de choix entre les parcours **Easy**, **Basic** et **Hard** avec affichage de leurs objectifs respectifs. | **P0** (Critique) |
| **Contenu pédagogique** | Consultation des leçons | Pages de cours présentant la règle grammaticale, sa structure syntaxique, des exemples bilingues contrastés et des remarques. | **P0** (Critique) |
| **Évaluation** | Passation de quiz | Questionnaire interactif (QCM à 4 options ou phrases à trou) associé à chaque leçon. | **P0** (Critique) |
| **Évaluation** | Correction automatique | Traitement algorithmique instantané des réponses fournies dès la soumission du quiz. | **P0** (Critique) |
| **Évaluation** | Restitution visuelle | Affichage dynamique du score obtenu (note chiffrée et pourcentage), mise en évidence des réponses correctes (vert) et incorrectes (rouge) avec explication. | **P0** (Critique) |
| **Suivi & Historique** | Enregistrement des scores | Sauvegarde en base de données MySQL de chaque tentative (id utilisateur, id quiz, score, date/heure). | **P0** (Critique) |
| **Suivi & Historique** | Historique personnel | Page ou section dédiée permettant à l'utilisateur de consulter l'ensemble de ses tentatives antérieures et son évolution. | **P1** (Majeure) |
| **Suivi & Historique** | Indicateur de progression | Calcul dynamique de l'avancement global (% de leçons consultées et de quiz validés par niveau). | **P1** (Majeure) |

---

## 8. Fonctionnalités non prioritaires (Post-MVP / Roadmap ultérieure)

Afin de préserver le respect du calendrier de développement et de garantir la qualité du noyau fonctionnel, les éléments suivants sont **strictement exclus du MVP** et reportés aux phases ultérieures (v2 / v3) :

```
                  CHRONOLOGIE DES VERSIONS
                            │
  ┌─────────────────────────┴─────────────────────────┐
  ▼                                                   ▼
MVP (Version 1.0)                      VERSIONS ULTÉRIEURES (v2 / v3)
- Comptes & sessions PHP               - Synthèse vocale & prononciation (TTS)
- 3 niveaux (Easy, Basic, Hard)        - Reconnaissance vocale (Speech-to-Text)
- Fiches de leçons                     - Gamification (badges, streaks, XP)
- Quiz interactifs & correction auto   - Mode chronométré & examens blancs
- Tableau de bord & historique BDD     - Back-office administration (CRUD cours)
                                       - Exportation de certificats PDF
                                       - PWA (mode hors-ligne)
```

1. **Reconnaissance et synthèse vocale (Audio & Speech-to-Text) :**
   * Écoute de la prononciation correcte des phrases d'exemple via l'API Web Speech.
   * Entraînement à la diction avec retour sur la justesse de prononciation.
2. **Système de gamification approfondi :**
   * Badges de réussite (« Master of Present », « Grammar Hero »).
   * Système de points d'expérience (XP), séries de jours consécutifs (*streaks*) et classement optionnel entre apprenants.
3. **Module de quiz chronométré (Mode Défi) :**
   * Évaluations sous contrainte de temps pour simuler des conditions d'examen.
4. **Back-office complet d'administration des contenus :**
   * Interface administrateur pour ajouter, modifier ou supprimer des leçons et des questions sans intervention directe en base de données SQL.
5. **Génération de certificats de réussite :**
   * Production d'un document PDF attestant de la complétion réussie d'un niveau avec le score moyen associé.
6. **Récupération de mot de passe par courriel automatique :**
   * Intégration d'un serveur SMTP pour la réinitialisation de mot de passe par lien sécurisé unique.
7. **Mode hors-ligne / Progressive Web App (PWA) :**
   * Mise en cache des leçons et quiz pour révision sans connexion internet.

---

## 9. Technologies envisagées

### 9.1 Justification de la stack technique

Le choix technologique retenu repose sur un ensemble d'outils standards, éprouvés, stables et parfaitement adaptés aux objectifs pédagogiques et contraintes d'apprentissage du développement web :

```
┌────────────────────────────────────────────────────────┐
│                      FRONT-END                         │
│       HTML5 (Sémantique)  ·  CSS3 (Responsive)         │
│             JavaScript Vanilla (ES6+)                  │
└───────────────────────────┬────────────────────────────┘
                            │ Requêtes HTTP (GET / POST)
┌───────────────────────────▼────────────────────────────┐
│                       BACK-END                         │
│             PHP 8.x (Architecture modulaire)           │
│        Sessions natives  ·  Extension PDO / Sécurité   │
└───────────────────────────┬────────────────────────────┘
                            │ Requêtes SQL préparées
┌───────────────────────────▼────────────────────────────┐
│                    BASE DE DONNÉES                     │
│                  MySQL / MariaDB                       │
│    Intégrité relationnelle  ·  Encodage UTF-8 (mb4)    │
└────────────────────────────────────────────────────────┘
```

* **HTML5 :** Garantit une structure sémantique claire (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`), favorable à l'accessibilité numérique et au bon référencement.
* **CSS3 :** Assure une interface moderne et responsive grâce à l'usage combiné de **Flexbox** et de **CSS Grid**, sans dépendance obligatoire à un framework tiers. Utilisation de variables CSS pour appliquer la charte graphique :
  * *Navy* (`#14213D`) : Couleurs dominantes, en-têtes et textes structurants.
  * *Teal* (`#2A9D8F`) : Identité du niveau Easy, validation et états de succès.
  * *Gold* (`#F4A261`) : Identité du niveau Basic, accents et avertissements.
  * *Red* (`#E63946`) : Identité du niveau Hard, boutons d'accentuation et erreurs.
  * *Cream* (`#F8F5EE`) : Fond d'interface doux favorisant le confort de lecture.
* **JavaScript (ES6+) :** Utilisé côté client pour dynamiser l'interface sans alourdir le navigateur : validation des champs de formulaire avant envoi, navigation pas-à-pas dans les questions du quiz, révélation immédiate du corrigé et gestion des interactions locales.
* **PHP 8.x :** Traitement côté serveur. Assure la logique métier, la vérification des données transmises, la gestion sécurisée des sessions utilisateurs (`$_SESSION`), le hachage des mots de passe et la communication avec la base de données.
* **MySQL (MariaDB) :** SGBD relationnel assurant le stockage fiable et persistant de l'ensemble des données du système. L'accès aux données sera exclusivement réalisé via la couche **PDO (PHP Data Objects)** pour prévenir les failles d'injection SQL.
* **XAMPP :** Environnement d'exécution local unifié combinant le serveur web Apache, le moteur PHP et le serveur de bases de données MariaDB, assurant une portabilité simple sur tout poste de développement Windows/macOS/Linux.

### 9.2 Modélisation prévisionnelle de la base de données

La structure relationnelle envisagée pour le MVP comprend 7 tables principales :

| Table | Rôle & Description | Champs clés prévus |
| :--- | :--- | :--- |
| **`utilisateurs`** | Stocke les comptes des apprenants. | `id`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_inscription` |
| **`niveaux`** | Définit les 3 paliers d'apprentissage. | `id`, `code` (`easy`, `basic`, `hard`), `titre`, `description`, `ordre` |
| **`lecons`** | Contient le contenu théorique des leçons. | `id`, `niveau_id`, `titre`, `slug`, `contenu_html`, `ordre` |
| **`quiz`** | Rattache une évaluation à une leçon. | `id`, `lecon_id`, `titre`, `description` |
| **`questions`** | Répertorie les questions de chaque quiz. | `id`, `quiz_id`, `enonce`, `explication`, `ordre` |
| **`options_reponses`** | Liste les choix possibles pour chaque question. | `id`, `question_id`, `texte_reponse`, `est_correcte` (booléen) |
| **`tentatives_quiz`** | Enregistre chaque passage de quiz et son score. | `id`, `utilisateur_id`, `quiz_id`, `score_obtenu`, `score_max`, `date_tentative` |

---

## 10. Contraintes et risques

### 10.1 Contraintes du projet
* **Contraintes d'environnement :** Le projet doit fonctionner nativement sous un serveur Apache local configuré via XAMPP, sans dépendances logicielles externes non standards.
* **Contraintes de sécurité :** Toute saisie utilisateur doit être considérée comme suspecte (protection systématique contre les injections SQL via requêtes préparées PDO et contre les failles XSS via `htmlspecialchars`).
* **Contraintes ergonomiques :** L'interface doit être conçue en approche *mobile-first*, garantissant que les boutons de quiz et les fiches de leçons restent facilement utilisables d'une seule main sur smartphone.
* **Contraintes de temporalité :** Le projet doit être segmenté en phases de développement claires pour garantir la livraison d'un produit opérationnel dans les délais impartis.

### 10.2 Matrice des risques et plans de mitigation

| Risque identifié | Probabilité | Impact | Plan d'action / Mitigation |
| :--- | :---: | :---: | :--- |
| **Failles de sécurité (Injections SQL, XSS, Session Hijacking)** | Moyenne | Élevé | Utilisation exclusive de l'API PDO avec requêtes préparées ; nettoyage systématique des sorties HTML ; régénération des identifiants de session (`session_regenerate_id()`) à la connexion. |
| **Complexité de calcul et d'enregistrement de la progression** | Moyenne | Moyen | Modélisation rigoureuse de la base de données dès la phase de conception ; mise en place de clés étrangères (`FOREIGN KEY`) et requêtes SQL d'agrégation testées en amont. |
| **Dérive du périmètre initial (*Scope Creep*)** | Élevée | Élevé | Respect strict de la frontière entre fonctionnalités MVP et fonctionnalités post-MVP définies dans cette note de cadrage. |
| **Problèmes de compatibilité multi-écrans** | Faible | Moyen | Recours à une grille CSS adaptative sans largeurs fixes et tests continus sous les outils d'inspection responsive des navigateurs (Chrome / Firefox). |
| **Données de test insuffisantes ou leçons vides** | Moyenne | Faible | Élaboration conjointe d'un fichier de migration SQL (`seed.sql`) injectant d'emblée un jeu complet de données de test (comptes fictifs, 3 niveaux, leçons rédigées, quiz associés). |

---

## 11. Résultats attendus et critères de succès

### 11.1 Livrables attendus au terme du développement
1. **Dépôt de code source structuré et documenté :**
   * Code front-end ordonné (feuilles de style CSS modulaires, scripts JavaScript découpés).
   * Code back-end PHP organisé (fichiers de configuration, gestion de base de données, templates de pages, traitement des formulaires).
2. **Base de données relationnelle opérationnelle :**
   * Script SQL de création des tables (`schema.sql`).
   * Script d'insertion des données de test initiales (`seed.sql`).
3. **Dossier documentaire complet :**
   * Note de cadrage validée (présent document).
   * Guide d'installation et de configuration locale sous XAMPP (`README.md`).

### 11.2 Critères d'acceptation fonctionnels (Définition de Terminé / *DoD*)
* [ ] Un internaute anonyme peut s'inscrire, et ses identifiants sont stockés de façon chiffrée dans la table `utilisateurs`.
* [ ] Un utilisateur enregistré peut ouvrir une session, accéder à son tableau de bord et se déconnecter proprement.
* [ ] L'utilisateur connecté peut sélectionner l'un des trois niveaux (**Easy**, **Basic**, **Hard**) et visualiser la liste des leçons correspondantes.
* [ ] L'utilisateur peut lire une fiche de cours structurée et lancer le quiz associé.
* [ ] Le quiz évalue les réponses soumises de manière 100 % automatisée et affiche immédiatement la note obtenue avec le corrigé explicatif.
* [ ] La tentative, la note et la date sont enregistrées avec succès dans la base de données.
* [ ] Le tableau de bord reflète fidèlement la progression de l'apprenant et répertorie l'historique complet de ses passages.

### 11.3 Indicateurs de qualité technique
* **Propreté du code :** Absence d'erreurs, de notices ou d'alertes PHP lors de la navigation (`error_reporting(E_ALL)`).
* **Robustesse :** Absence de blocage applicatif lors de la saisie de caractères spéciaux ou de formulaires incomplets.
* **Fluidité d'usage :** Temps d'affichage quasi-instantané en environnement local XAMPP.

---

## Conclusion et prochaines étapes

La présente note de cadrage pose les fondations fonctionnelles, techniques et ergonomiques du projet **Speech English**. Elle garantit un alignement parfait entre les besoins pédagogiques identifiés et les choix d'implémentation retenus autour de la stack PHP/MySQL/XAMPP.

**Prochaines étapes de réalisation :**
1. Validation définitive du schéma relationnel de la base de données.
2. Finalisation de la structure des dossiers et initialisation du socle applicatif sous XAMPP.
3. Intégration des gabarits HTML5/CSS3 (Dashboard, Leçons, Quiz).
4. Développement des scripts PHP de gestion des comptes et de persistance des quiz.
5. Intégration des contenus pédagogiques et phase de tests fonctionnels globaux.

