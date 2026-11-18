# ADR 001 : Choix de la Stack Technique

*   **Statut :** Accepté
*   **Décideur :** Camara Abdal Wadoud (Chef de projet)
*   **Date :** 18/11/2026

## Contexte et Problème

Pour le projet **Speech English**, nous devons choisir une stack technique permettant de construire une application web robuste, éducative et conforme aux exigences académiques du module "Fondamentaux du Web" (MIAGE 2ème année). L'application doit gérer l'authentification, le contenu pédagogique et un moteur de quiz interactif.

## Décision

Nous avons opté pour une stack **"LAMP" locale (Windows / XAMPP)** basée sur les technologies fondamentales du web :

1.  **Langage Serveur :** PHP 8.x (Vanilla).
2.  **Base de données :** MySQL / MariaDB via PDO.
3.  **Front-end :** HTML5, CSS3 (Custom Properties), JavaScript (ES6+).
4.  **Serveur Local :** Apache via XAMPP.
5.  **Architecture :** Modèle-Vue-Contrôleur (MVC) personnalisé.

## Justification

*   **Conformité Académique :** Le projet impose l'utilisation des technologies web fondamentales (HTML, CSS, JS, PHP, SQL). L'utilisation de frameworks lourds (Laravel, Symfony, React) a été écartée pour démontrer une maîtrise des concepts de base.
*   **Architecture MVC :** Bien qu'en PHP Vanilla, l'adoption d'un pattern MVC permet une séparation claire des responsabilités (logique métier, accès aux données, affichage), facilitant la maintenance et l'évolution du projet.
*   **Sécurité :** L'utilisation systématique de PDO permet l'utilisation de requêtes préparées, protégeant l'application contre les injections SQL.
*   **Performance :** Pour une application de cette taille, le PHP orienté objet simple offre des temps de réponse excellents sans surcharge inutile.

## Conséquences

*   **Positives :**
    *   Code source clair et facile à auditer.
    *   Déploiement simple par copier-coller et import SQL.
*   **Négatives :**
    *   Nécessite une gestion manuelle du routage et de la sécurité (XSS, CSRF).
