# Speech English 🎓

Application web d'apprentissage de la grammaire anglaise en trois niveaux (Easy, Basic, Hard).

Projet développé avec **HTML**, **CSS**, **JavaScript**, **PHP** et **MySQL** sous environnement local **XAMPP**.

---

## 🏗️ Architecture du Projet (Modèle MVC)

Le projet adopte une organisation **Modèle-Vue-Contrôleur (MVC)** simple et modulaire :

```text
SpeechEnglish/
│
├── app/
│   ├── config/              # Fichiers de configuration (connexion BDD, constantes)
│   ├── controllers/         # Contrôleurs : logique applicative et traitement des requêtes
│   ├── models/              # Modèles : gestion des données et requêtes SQL
│   ├── views/               # Vues : interfaces utilisateur et gabarits HTML/PHP
│   │   ├── auth/            # Écrans d'authentification (connexion, inscription)
│   │   ├── dashboard/       # Écrans d'accueil et tableau de bord
│   │   ├── lessons/         # Écrans de consultation des leçons par niveau
│   │   ├── quizzes/         # Écrans de passation des quiz
│   │   └── results/         # Écrans d'affichage des scores et de l'historique
│   └── helpers/             # Fonctions utilitaires réutilisables (sécurité, session, etc.)
│
├── public/                  # Racine web publique (seul dossier accessible par le navigateur)
│   ├── assets/              # Ressources statiques front-end
│   │   ├── css/             # Feuilles de style CSS
│   │   ├── js/              # Scripts JavaScript
│   │   └── images/          # Images, logos et icônes
│   ├── index.php            # Point d'entrée unique de l'application (Front Controller)
│   └── .htaccess            # Règles de réécriture d'URL Apache
│
├── database/                # Scripts SQL (schéma relationnel, données d'initialisation)
├── documentation/           # Documents de cadrage, kick-off et conception du projet
├── tests/                   # Scripts de tests unitaires et d'intégration
│
├── .env.example             # Modèle des variables d'environnement à configurer
├── .gitignore               # Fichiers et dossiers ignorés par le versioning Git
├── composer.json            # Configuration Composer et autoloading PSR-4
└── README.md                # Documentation générale du projet
```

---

## 📂 Rôle de Chaque Dossier

| Dossier | Rôle et Responsabilité |
| :--- | :--- |
| **`app/config/`** | Centralise la configuration de l'application (paramètres de connexion MySQL via PDO, constantes globales). |
| **`app/controllers/`** | Contient les classes Contrôleurs qui reçoivent les requêtes utilisateur, sollicitent les modèles et transmettent les données aux vues. |
| **`app/models/`** | Contient les classes Modèles qui interagissent directement avec la base de données MySQL (CRUD, requêtes préparées). |
| **`app/views/`** | Regroupe les fichiers d'affichage (HTML/PHP). Découpé par module fonctionnel (`auth`, `dashboard`, `lessons`, `quizzes`, `results`). |
| **`app/helpers/`** | Héberge les fonctions d'assistance globales (nettoyage des entrées, contrôle des sessions, redirections). |
| **`public/`** | Point d'entrée unique du serveur web Apache pour des raisons de sécurité (isole les fichiers de code source de l'accès web direct). |
| **`public/assets/`** | Stocke les fichiers statiques servis au navigateur client (`css`, `js`, `images`). |
| **`database/`** | Accueille les scripts SQL de création des tables (`schema.sql`) et les données de test (`seed.sql`). |
| **`documentation/`** | Rassemble tous les livrables d'avant-projet (note de cadrage, compte-rendu de kick-off, parcours d'onboarding, ADR). |
| **`tests/`** | Dédié aux tests automatisés (validation du code, tests de régression). |

---

## ⚙️ Fichiers de Configuration

* **`public/index.php`** : Front Controller qui initialise la session, charge l'autoloader et centralise le routage des requêtes.
* **`public/.htaccess`** : Redirige l'ensemble du trafic web vers `index.php` tout en autorisant l'accès direct aux fichiers réels (CSS, JS, images).
* **`.env.example`** : Gabarit des variables d'environnement (identifiants MySQL XAMPP) sans données sensibles.
* **`.gitignore`** : Empêche le suivi Git des fichiers locaux (`.env`), des dépendances (`vendor/`) et des fichiers système temporaires.
* **`composer.json`** : Définit la configuration standard du projet et l'autoloading PSR-4 associant le namespace `App\` au dossier `app/`.
