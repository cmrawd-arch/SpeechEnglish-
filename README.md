# Speech English 🇬🇧

**Speech English** est une application web éducative conçue pour accompagner l'apprentissage de la grammaire anglaise de manière progressive et interactive.

Ce projet a été développé dans le cadre du module **Fondamentaux du Web** (MIAGE 2ème année).

---

## 👥 Équipe Projet

*   **Camara Abdal Wadoud** : Chef de projet & Développeur principal (Back-end, Architecture, BDD).
*   **Sahoue Bi Ballou** : Responsable fonctionnel et qualité (Tests, Validation).
*   **Yeo Issouf** : Responsable documentation & Environnement technique.
*   **Naounou Djati Nathan** : Responsable UX/UI & Interface utilisateur.

---

## 🚀 Installation et Lancement

Pour faire fonctionner l'application localement, suivez ces étapes :

### 1. Prérequis
*   Avoir installé **XAMPP** (ou un équivalent WAMP/MAMP) avec **PHP 8.x**.
*   Serveur **Apache** et **MySQL** activés.

### 2. Installation de la base de données
1.  Ouvrez **phpMyAdmin** (`http://localhost/phpmyadmin`).
2.  Créez une nouvelle base de données nommée `speech_english`.
3.  Importez le fichier `database/schema.sql` pour créer les tables.
4.  Importez le fichier `database/seed.sql` pour insérer le contenu pédagogique (leçons et quiz).

### 3. Configuration de l'application
1.  Placez le dossier du projet dans votre répertoire `htdocs` (généralement `C:\xampp\htdocs\SpeechEnglish`).
2.  Copiez le fichier `.env.example` et renommez-le en `.env`.
3.  Vérifiez les informations de connexion dans le fichier `.env` (DB_USER, DB_PASS, etc.).

### 4. Lancement
Accédez à l'application via votre navigateur :
`http://localhost/SpeechEnglish/public/`

---

## 🛠️ Architecture Technique

L'application repose sur une architecture **MVC (Modèle-Vue-Contrôleur)** personnalisée en PHP Vanilla, sans frameworks externes, pour respecter les contraintes pédagogiques :

*   **`public/`** : Point d'entrée de l'application (`index.php`), fichiers CSS, JS et images.
*   **`app/`** : Cœur de l'application.
    *   **`controllers/`** : Gestion de la logique de contrôle et du routage.
    *   **`models/`** : Interactions avec la base de données via PDO.
    *   **`views/`** : Fichiers HTML/PHP pour l'affichage.
    *   **`config/`** : Configuration de la base de données.
    *   **`helpers/`** : Fonctions utilitaires (redirection, flash messages).
*   **`database/`** : Scripts SQL de structure et de données.
*   **`documentation/`** : Note de cadrage, ADR, Kick-Off et Onboarding.

---

## 🔑 Fonctionnalités Clés

*   **Authentification sécurisée** : Inscription et connexion avec hachage des mots de passe.
*   **Tableau de bord dynamique** : Vue d'ensemble de la progression et statistiques en temps réel.
*   **Parcours par niveaux** : Organisation du contenu en 3 paliers (Easy, Basic, Hard).
*   **Moteur de Quiz** : Validation côté serveur, correction immédiate et explications pédagogiques.
*   **Historique détaillé** : Suivi précis de chaque tentative avec score et date.
