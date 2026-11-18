<?php

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

/**
 * =============================================================================
 * Classe Database — Gestionnaire de connexion PDO MySQL
 * Projet : Speech English
 * =============================================================================
 * 
 * Respecte les exigences :
 * - Utilisation de PDO avec déclenchement systématique des exceptions (ERRMODE_EXCEPTION).
 * - Encodage forcé en utf8mb4 (DSN + init command).
 * - Requêtes préparées natives (EMULATE_PREPARES désactivé).
 * - Aucune information sensible (hôte, utilisateur, mot de passe) codée en dur.
 * - Récupération stricte depuis les variables d'environnement (.env).
 * - Masquage complet des mots de passe et données sensibles en cas d'erreur.
 */
class Database
{
    private static ?PDO $connection = null;

    /**
     * Charge les variables depuis le fichier .env si elles ne sont pas déjà définies.
     *
     * @param string|null $envFile Chemin optionnel vers le fichier .env
     */
    public static function loadEnvironment(?string $envFile = null): void
    {
        $path = $envFile ?: dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env';

        if (!file_exists($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);

            // Ignorer les commentaires et lignes vides
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                // Ne pas écraser une variable d'environnement existante
                if (getenv($key) === false) {
                    putenv("{$key}={$value}");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }

    /**
     * Retourne une instance unique de PDO (Pattern Singleton).
     *
     * @return PDO
     * @throws RuntimeException En cas de configuration manquante ou d'échec de connexion.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            // 1. Chargement de l'environnement
            self::loadEnvironment();

            // 2. Lecture des paramètres depuis les variables d'environnement
            $host    = getenv('DB_HOST');
            $port    = getenv('DB_PORT') ?: '3306';
            $dbname  = getenv('DB_NAME');
            $user    = getenv('DB_USER');
            $pass    = getenv('DB_PASS');
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

            // 3. Validation de la présence des variables requises
            if ($host === false || $dbname === false || $user === false) {
                throw new RuntimeException(
                    "Paramètres de connexion manquants. Veuillez configurer DB_HOST, DB_NAME et DB_USER dans votre fichier .env."
                );
            }

            // 4. Construction sécurisée du DSN avec encodage utf8mb4
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            // 5. Options PDO strictes
            $options = [
                // Déclenchement automatique d'exceptions en cas d'erreur SQL
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                // Récupération par défaut sous forme de tableau associatif
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // Désactivation de l'émulation : requêtes préparées réelles côté serveur
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Définition de l'encodage de connexion
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$charset}' COLLATE '{$charset}_unicode_ci'",
                // Délai d'attente maximum (secondes)
                PDO::ATTR_TIMEOUT            => 5,
            ];

            // 6. Tentative de connexion avec gestion étanche des erreurs
            try {
                self::$connection = new PDO($dsn, $user, $pass !== false ? $pass : '', $options);
            } catch (PDOException $e) {
                // Journalisation sécurisée de l'erreur dans les logs système (non visible par l'utilisateur)
                error_log("[Database Connection Error] " . $e->getMessage());

                // Masquage absolu du mot de passe et du DSN :
                // On lève une exception générique sans jamais divulguer les identifiants
                throw new RuntimeException(
                    "Erreur de connexion à la base de données : impossible d'établir la communication avec le serveur MySQL. " .
                    "Veuillez vérifier que le service MySQL est démarré et que les accès dans .env sont corrects."
                );
            }
        }

        return self::$connection;
    }

    /**
     * Réinitialise la connexion (utile pour les tests ou les changements d'environnement).
     */
    public static function disconnect(): void
    {
        self::$connection = null;
    }
}

// Fonction globale d'aide (Helper) pour obtenir la connexion rapidement
if (!function_exists('getDatabase')) {
    function getDatabase(): PDO
    {
        return Database::getConnection();
    }
}

// Mode CLI autonome : permet de tester directement le fichier en ligne de commande
// Exécution : php app/config/database.php
if (php_sapi_name() === 'cli' && isset($argv[0]) && realpath($argv[0]) === realpath(__FILE__)) {
    echo "====================================================\n";
    echo " Test de connexion à la base de données (PDO)\n";
    echo "====================================================\n";

    try {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT VERSION() as version, DATABASE() as dbname, @@character_set_connection as charset");
        $data = $stmt->fetch();

        echo "[OK] Connexion établie avec succès !\n";
        echo " - Serveur : " . $data['version'] . "\n";
        echo " - Base actuelle : " . ($data['dbname'] ?: '(aucune)') . "\n";
        echo " - Jeu de caractères : " . $data['charset'] . "\n";
        echo " - Moteur PDO : actif (ERRMODE_EXCEPTION, EMULATE_PREPARES = false)\n";
        echo "====================================================\n";
        exit(0);
    } catch (\Throwable $e) {
        echo "[ERREUR] Échec de la connexion :\n";
        echo " -> " . $e->getMessage() . "\n";
        echo "====================================================\n";
        exit(1);
    }
}
