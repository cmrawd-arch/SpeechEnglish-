# ADR 002 : Modélisation et Choix du Système de Gestion de Base de Données

*   **Statut :** Accepté
*   **Décideur :** Camara Abdal Wadoud (Chef de projet)
*   **Date :** 18/11/2026

## Contexte et Problème

L'application **Speech English** nécessite de stocker des données structurées : comptes utilisateurs, catalogue de leçons, questions de quiz et surtout, le suivi de la progression et les scores des apprenants. Nous avons besoin d'un système fiable, gérant les relations entre ces entités et facile à intégrer avec PHP.

## Décision

Nous avons choisi d'utiliser **MySQL (MariaDB)** comme système de gestion de base de données relationnelle (SGBDR).

Le schéma est structuré autour des tables suivantes :
*   `utilisateurs` : Stockage des profils.
*   `lecons` & `niveaux` : Organisation du contenu.
*   `quizzes`, `questions`, `options_reponses` : Structure hiérarchique du moteur d'évaluation.
*   `tentatives_quiz` : Table pivot enregistrant les performances (scores, bonnes/mauvaises réponses).
*   `progression_lecons` : Suivi de l'état d'avancement par utilisateur.

## Justification

*   **Modèle Relationnel :** Les données de Speech English sont fortement liées. Un SGBDR est parfaitement adapté pour garantir l'intégrité référentielle.
*   **Performance des Jointures :** MySQL excelle dans le traitement des jointures nécessaires pour afficher le tableau de bord et l'historique des quiz.
*   **Standard du Marché :** MySQL est le compagnon historique de PHP, offrant une intégration native via l'extension PDO.
*   **Facilité d'Administration :** L'utilisation de phpMyAdmin permet à toute l'équipe de visualiser les données facilement.

## Conséquences

*   **Positives :**
    *   Intégrité référentielle garantie par les clés étrangères.
    *   Schéma évolutif.
    *   Exportation simple via un fichier `.sql` unique.
*   **Négatives :**
    *   Nécessite une gestion manuelle des scripts SQL (`schema.sql`, `seed.sql`).
