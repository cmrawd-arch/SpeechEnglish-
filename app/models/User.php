<?php

namespace App\Models;

use App\Config\Database;
use PDO;

/**
 * Modèle User — Gestion des utilisateurs dans MySQL
 */
class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Recherche un utilisateur par son identifiant unique.
     *
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT id, nom, prenom, email, date_creation 
                FROM utilisateurs 
                WHERE id = :id 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    /**
     * Recherche un utilisateur par son adresse email avec une requête préparée.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT id, nom, prenom, email, mot_de_passe, date_creation 
                FROM utilisateurs 
                WHERE email = :email 
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => strtolower(trim($email))]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    /**
     * Vérifie si une adresse email est déjà enregistrée en BDD.
     *
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => strtolower(trim($email))]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Crée un nouvel utilisateur avec mot de passe haché de manière sécurisée.
     *
     * Exigence : Ne jamais stocker de mot de passe en clair.
     *
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param string $plainPassword Mot de passe en clair à hacher
     * @return int Identifiant de l'utilisateur inséré
     */
    public function create(string $nom, string $prenom, string $email, string $plainPassword): int
    {
        // Hachage cryptographique sécurisé (bcrypt/argon2 par défaut sous PHP 8)
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, date_creation) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nom'          => trim($nom),
            'prenom'       => trim($prenom),
            'email'        => strtolower(trim($email)),
            'mot_de_passe' => $hashedPassword,
        ]);

        return (int) $this->db->lastInsertId();
    }
}

