# Compte-Rendu de Réunion de Kick-Off — Projet Speech English

---

## Informations Générales sur la Réunion

| Propriété | Détail |
| :--- | :--- |
| **Intitulé du projet** | **Speech English** |
| **Cadre du projet** | TD de Fondamentaux du Web — MIAGE 2ème année |
| **Type de réunion** | Réunion de lancement (Kick-Off Meeting) |
| **Date de la réunion** | 18/11/2026 |
| **Horaires** | 14h00 - 16h00 |
| **Lieu / Format** | Salle de TD / Visioconférence |
| **Rédacteur du compte-rendu** | Yeo Issouf |
| **Version du document** | 1.0 |
| **Statut** | Validé par l'équipe |

### Équipe projet et émargement

| Rôle | Membre assigné | Statut de présence |
| :--- | :--- | :---: |
| **Chef de projet & Développeur principal** | Camara Abdal Wadoud | Présent |
| **Responsable fonctionnel et qualité** | Sahoue Bi Ballou | Présent |
| **Responsable documentation & Env. technique** | Yeo Issouf | Présent |
| **Responsable UX/UI et interface** | Naounou Djati Nathan | Présent |

---

## 1. Objectif de la réunion

La réunion de lancement a pour vocation d'officialiser le démarrage du projet **Speech English** dans le cadre du module *Fondamentaux du Web* en MIAGE 2ème année.

### Ordre du jour et objectifs de la séance :
1. Présenter la vision générale du projet, la problématique ciblée et la proposition de valeur.
2. Aligner l'équipe sur les objectifs pédagogiques et académiques à atteindre.
3. Attribuer officiellement les responsabilités de chacun des quatre membres.
4. Établir la méthode de travail et les outils collaboratifs.
5. Inventorier les premiers risques opérationnels et entériner les décisions structurantes.

---

## 2. Présentation du projet

### 2.1 Synthèse de l'application
**Speech English** est une application web d'apprentissage de l'anglais principalement axée sur la **maîtrise progressive de la grammaire**. 

L'application propose un parcours d'apprentissage découpé en trois niveaux d'acquisition :
* **Easy (Débutant / Primary) :** Fondamentaux des temps simples.
* **Basic (Intermédiaire / College) :** Maîtrise des aspects et nuances temporelles.
* **Hard (Avancé / High School & Pro) :** Structures complexes.

### 2.2 Périmètre du MVP validé en séance
L'équipe s'accorde sur un périmètre restreint et robuste pour le MVP :
* Gestion des comptes apprenants (inscription, connexion/déconnexion sécurisée).
* Tableau de bord personnel visualisant la progression.
* Consultation de fiches de cours synthétiques.
* Moteur de quiz interactif avec correction automatique instantanée.
* Enregistrement en base de données et historique complet des résultats.

---

## 3. Objectifs de l'équipe

### 3.1 Objectifs académiques
* Satisfaire l'intégralité du cahier des charges du TD.
* Démontrer une mise en œuvre maîtrisée des technologies web fondamentales.

### 3.2 Objectifs techniques et qualitatifs
* **Modularité :** Architecture MVC propre en PHP.
* **Sécurité :** Requêtes préparées PDO, hachage des mots de passe, gestion sécurisée des sessions.
* **Ergonomie :** Interface adaptative (Responsive Web Design).

---

## 4. Répartition des responsabilités

### 4.1 Fiches de rôles détaillées

#### Camara Abdal Wadoud (Chef de projet & Développeur principal)
* Coordination générale de l'équipe.
* Architecture MVC et conception de la base de données.
* Développement Back-end PHP (Auth, Cours, Quiz, Scores).
* Gestion de la progression et intégration technique.

#### Sahoue Bi Ballou (Responsable fonctionnel et qualité)
* Vérification fonctionnelle de l'application.
* Tests de bout en bout (Inscription, Connexion, Quiz, Résultats).
* Validation des critères d'acceptation (DoD).

#### Yeo Issouf (Responsable documentation et environnement technique)
* Rédaction et actualisation de la documentation technique (README, ADR).
* Configuration et documentation de l'environnement technique (XAMPP, .env).
* Organisation du dossier documentaire.

#### Naounou Djati Nathan (Responsable UX/UI et interface utilisateur)
* Vérification de la cohérence visuelle et des interfaces.
* Actualisation du parcours utilisateur (Onboarding).
* Préparation des éléments visuels pour la présentation finale.

---

## 5. Méthode de communication et outils

### 5.1 Outils de travail
* **Environnement :** XAMPP (Apache, PHP 8, MariaDB).
* **Éditeur :** Antigravity / VS Code.
* **Versionning :** Git.
* **Design :** Figma.

### 5.2 Rituels d'équipe
* Points réguliers pour le suivi de l'avancement.
* Communication asynchrone pour le partage d'informations techniques.

---

## 6. Décisions prises

1. **Architecture :** Adoption d'un modèle MVC strict en PHP Vanilla.
2. **Design :** Charte graphique basée sur les couleurs Navy, Teal, Gold et Red.
3. **Sécurité :** Utilisation systématique de PDO et `password_hash`.
4. **MVP :** Focus sur le cycle "Leçon -> Quiz -> Résultat -> Historique".
