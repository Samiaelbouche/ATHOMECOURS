CREATE DATABASE IF NOT EXISTS athomecours;
USE athomecours;


CREATE TABLE IF NOT EXISTS eleves (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_naissance DATE,
    adresse TEXT,
    ville VARCHAR(100),
    code_postal VARCHAR(5),
    telephone VARCHAR(20),
    niveau_scolaire ENUM('college', 'lycee') NOT NULL,
    classe VARCHAR(20),
    etablissement VARCHAR(100),
    nom_parent VARCHAR(100),
    telephone_parent VARCHAR(20),
    email_parent VARCHAR(100),
    besoins_particuliers TEXT,
    statut ENUM('en_attente','valide','refuse') DEFAULT 'en_attente'
    );


CREATE TABLE IF NOT EXISTS professeurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_naissance DATE,
    adresse TEXT,
    ville VARCHAR(100),
    code_postal VARCHAR(5),
    telephone VARCHAR(20),
    diplome VARCHAR(100),
    experience_annees INT DEFAULT 0,
    disponibilites TEXT,
    motivation TEXT,
    cv_url VARCHAR(255),
    modalite_cours ENUM('domicile','en_ligne','les deux') NOT NULL DEFAULT 'en_ligne',
    statut ENUM('en_attente','valide','refuse') DEFAULT 'en_attente',
    date_verification TIMESTAMP NULL
    );
CREATE TABLE IF NOT EXISTS paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eleve_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    type_paiement ENUM('unite','forfait') NOT NULL,
    mode_paiement ENUM('en_ligne','domicile') NOT NULL,
    statut ENUM('en_attente','confirme','echoue') DEFAULT 'en_attente',
    date_paiement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_debut DATE,
    date_fin DATE,
    stripe_session_id VARCHAR(255),
    stripe_payment_intent_id VARCHAR(255),
    FOREIGN KEY (eleve_id) REFERENCES eleves(id) ON DELETE CASCADE,
    INDEX (eleve_id)
    );

CREATE TABLE IF NOT EXISTS cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eleve_id INT NOT NULL,
    professeur_id INT NOT NULL,
    date_cours DATETIME NOT NULL,
    duree_minutes INT NOT NULL DEFAULT 90,
    lieu ENUM('domicile','en_ligne') NOT NULL,
    adresse_cours TEXT,
    statut ENUM('planifie','confirme','en_cours','termine','annule') DEFAULT 'planifie',
    prix DECIMAL(10,2) NOT NULL DEFAULT 0,
    type_paiement ENUM('unite','forfait') NOT NULL DEFAULT 'unite',
    notes_cours TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paiement_id INT NULL,
    FOREIGN KEY (eleve_id) REFERENCES eleves(id) ON DELETE CASCADE,
    FOREIGN KEY (professeur_id) REFERENCES professeurs(id) ON DELETE CASCADE,
    FOREIGN KEY (paiement_id) REFERENCES paiements(id) ON DELETE SET NULL
    );


CREATE TABLE IF NOT EXISTS disponibilites_prof (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professeur_id INT NOT NULL,
    jour_semaine ENUM('lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    actif BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (professeur_id) REFERENCES professeurs(id) ON DELETE CASCADE
    );


CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
    );


CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiration DATETIME NOT NULL,
    used TINYINT(1) DEFAULT 0
    );

UPDATE cours
SET prix = CASE
               WHEN lieu = 'en_ligne' THEN 30.00
               WHEN lieu = 'domicile' THEN 35.00
    END,
    type_paiement = 'unite'
WHERE prix = 0;


INSERT INTO admins (nom, prenom, email, mot_de_passe) VALUES
    ('Samiaelb', 'Admin', 'samia.elbouche@laposte.net', '$2y$10$P/rM3zBje1Qq2PaE4GTLnOhlOO5.NS2e1.A71ApyDpnJPBqS/GL5O');

