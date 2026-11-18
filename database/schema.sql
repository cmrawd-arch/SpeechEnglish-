-- =============================================================================
-- BASE DE DONNÉES : speech_english
-- Projet : Speech English — Plateforme d'apprentissage de la grammaire anglaise
-- Technologies : MySQL / MariaDB (XAMPP)
-- Moteur : InnoDB | Encodage : UTF-8 (utf8mb4 / utf8mb4_unicode_ci)
-- =============================================================================

CREATE DATABASE IF NOT EXISTS `speech_english`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `speech_english`;

-- -----------------------------------------------------------------------------
-- Suppression des tables existantes dans l'ordre inverse des dépendances (FK)
-- -----------------------------------------------------------------------------
DROP TABLE IF EXISTS `progression_lecons`;
DROP TABLE IF EXISTS `tentatives_quiz`;
DROP TABLE IF EXISTS `propositions_reponses`;
DROP TABLE IF EXISTS `questions`;
DROP TABLE IF EXISTS `quiz`;
DROP TABLE IF EXISTS `lecons`;
DROP TABLE IF EXISTS `niveaux`;
DROP TABLE IF EXISTS `utilisateurs`;

-- =============================================================================
-- 1. Table `utilisateurs`
-- Gestion des comptes apprenants. Mots de passe stockés sous forme de hash.
-- =============================================================================
CREATE TABLE `utilisateurs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(191) NOT NULL UNIQUE,
    `mot_de_passe` VARCHAR(255) NOT NULL COMMENT 'Hash bcrypt ou argon2 (jamais en clair)',
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 2. Table `niveaux`
-- Définition des 3 paliers pédagogiques : Easy (débutant), Basic (intermédiaire), Hard (avancé).
-- =============================================================================
CREATE TABLE `niveaux` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(20) NOT NULL UNIQUE COMMENT 'Identifiant court : easy, basic, hard',
    `titre` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `ordre` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 3. Table `lecons`
-- Gestion des cours de grammaire associés à un niveau.
-- =============================================================================
CREATE TABLE `lecons` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `niveau_id` INT UNSIGNED NOT NULL,
    `titre` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) NOT NULL UNIQUE,
    `contenu` LONGTEXT NOT NULL COMMENT 'Règles, structures, exemples bilingues et remarques',
    `ordre` INT UNSIGNED NOT NULL DEFAULT 1,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_lecons_niveaux`
        FOREIGN KEY (`niveau_id`) REFERENCES `niveaux` (`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_lecons_niveau` ON `lecons` (`niveau_id`);

-- =============================================================================
-- 4. Table `quiz`
-- Évaluation formative liée à une leçon (relation 1 à 1 : une leçon = un quiz).
-- =============================================================================
CREATE TABLE `quiz` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `lecon_id` INT UNSIGNED NOT NULL UNIQUE COMMENT 'Chaque leçon possède un quiz d évaluation unique',
    `titre` VARCHAR(150) NOT NULL,
    `description` TEXT NULL,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_quiz_lecons`
        FOREIGN KEY (`lecon_id`) REFERENCES `lecons` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- 5. Table `questions`
-- Questions associées à un quiz avec leur explication pédagogique.
-- =============================================================================
CREATE TABLE `questions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `quiz_id` INT UNSIGNED NOT NULL,
    `enonce` TEXT NOT NULL,
    `explication` TEXT NULL COMMENT 'Explication affichée lors de la correction pour justifier la règle',
    `points` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `ordre` INT UNSIGNED NOT NULL DEFAULT 1,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_questions_quiz`
        FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_questions_quiz` ON `questions` (`quiz_id`);

-- =============================================================================
-- 6. Table `propositions_reponses`
-- Choix de réponses pour chaque question de quiz (QCM).
-- =============================================================================
CREATE TABLE `propositions_reponses` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `question_id` INT UNSIGNED NOT NULL,
    `texte_reponse` VARCHAR(255) NOT NULL,
    `est_correcte` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 si bonne réponse, 0 sinon',
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_propositions_questions`
        FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_propositions_question` ON `propositions_reponses` (`question_id`);

-- =============================================================================
-- 7. Table `tentatives_quiz`
-- Historique et enregistrement des scores obtenus par les apprenants.
-- =============================================================================
CREATE TABLE `tentatives_quiz` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `utilisateur_id` INT UNSIGNED NOT NULL,
    `quiz_id` INT UNSIGNED NOT NULL,
    `score_obtenu` INT UNSIGNED NOT NULL,
    `score_max` INT UNSIGNED NOT NULL,
    `bonnes_reponses` INT UNSIGNED NOT NULL DEFAULT 0,
    `mauvaises_reponses` INT UNSIGNED NOT NULL DEFAULT 0,
    `pourcentage` DECIMAL(5,2) NOT NULL COMMENT 'Score en pourcentage (ex: 80.00)',
    `date_tentative` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_tentatives_utilisateurs`
        FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_tentatives_quiz`
        FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_tentatives_utilisateur` ON `tentatives_quiz` (`utilisateur_id`);
CREATE INDEX `idx_tentatives_quiz` ON `tentatives_quiz` (`quiz_id`);

-- =============================================================================
-- 8. Table `progression_lecons`
-- Suivi de progression : statut d avancement de chaque utilisateur par leçon.
-- =============================================================================
CREATE TABLE `progression_lecons` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `utilisateur_id` INT UNSIGNED NOT NULL,
    `lecon_id` INT UNSIGNED NOT NULL,
    `statut` ENUM('non_commence', 'en_cours', 'termine') NOT NULL DEFAULT 'en_cours',
    `date_derniere_consultation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `date_completion` DATETIME NULL DEFAULT NULL,
    UNIQUE KEY `unique_utilisateur_lecon` (`utilisateur_id`, `lecon_id`),
    CONSTRAINT `fk_progression_utilisateurs`
        FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_progression_lecons`
        FOREIGN KEY (`lecon_id`) REFERENCES `lecons` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX `idx_progression_utilisateur` ON `progression_lecons` (`utilisateur_id`);
CREATE INDEX `idx_progression_lecon` ON `progression_lecons` (`lecon_id`);

