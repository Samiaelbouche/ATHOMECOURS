
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
    niveau_scolaire ENUM('college', 'lycee' ) NOT NULL,
    classe VARCHAR(20),
    etablissement VARCHAR(100),
    nom_parent VARCHAR(100),
    telephone_parent VARCHAR(20),
    email_parent VARCHAR(100),
    besoins_particuliers TEXT

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
    statut_verification ENUM('en_attente', 'verifie', 'refuse') DEFAULT 'en_attente',
    date_verification TIMESTAMP NULL

);
CREATE TABLE IF NOT EXISTS cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eleve_id INT NOT NULL,
    professeur_id INT NOT NULL,
    date_cours DATETIME NOT NULL,
    duree_minutes INT NOT NULL DEFAULT 90,
    lieu ENUM('domicile_eleve', 'domicile_prof', 'en_ligne', 'autre') NOT NULL,
    adresse_cours TEXT,
    statut ENUM('planifie', 'confirme', 'en_cours', 'termine', 'annule') DEFAULT 'planifie',
    notes_cours TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (eleve_id) REFERENCES eleves(id) ON DELETE CASCADE,
    FOREIGN KEY (professeur_id) REFERENCES professeurs(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS disponibilites_prof (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professeur_id INT NOT NULL,
    jour_semaine ENUM('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    actif BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (professeur_id) REFERENCES professeurs(id) ON DELETE CASCADE
);

ALTER TABLE professeurs ADD COLUMN statut ENUM('en_attente','valide','refuse') DEFAULT 'en_attente';
ALTER TABLE eleves ADD COLUMN statut ENUM('en_attente','valide','refuse') DEFAULT 'en_attente';



CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
    );

INSERT INTO eleves
(nom, prenom, email, mot_de_passe, date_naissance, adresse, ville, code_postal, telephone, niveau_scolaire, classe, etablissement, nom_parent, telephone_parent, email_parent, besoins_particuliers)
VALUES
    ('Dupont', 'Marie', 'marie.dupont@example.com', 'motdepasse123', '2008-05-12', '12 rue de la Paix', 'Paris', '75001', '0601020304', 'college', '5ème A', 'Collège Jean Moulin', 'Jean Dupont', '0605060708', 'parent.dupont@example.com', 'Allergie aux cacahuètes'),
    ('Martin', 'Lucas', 'lucas.martin@example.com', 'motdepasse456', '2007-09-30', '45 avenue Victor Hugo', 'Lyon', '69003', '0612345678', 'college', '4ème B', 'Collège Victor Hugo', 'Claire Martin', '0611223344', 'parent.martin@example.com', NULL),
    ('Bernard', 'Emma', 'emma.bernard@example.com', 'motdepasse789', '2006-03-15', '8 boulevard Saint-Germain', 'Paris', '75005', '0609876543', 'lycee', '2nde C', 'Lycée Louis-le-Grand', 'Paul Bernard', '0601122334', 'parent.bernard@example.com', 'Besoin d’un accompagnement en maths'),
    ('Lefevre', 'Nathan', 'nathan.lefevre@example.com', 'motdepasse321', '2005-12-01', '23 rue Lafayette', 'Marseille', '13001', '0698765432', 'lycee', '1ère B', 'Lycée Thiers', 'Sophie Lefevre', '0699988776', 'parent.lefevre@example.com', NULL);





INSERT INTO admins (nom, prenom, email, mot_de_passe)
VALUES ('Samiaelb', 'Admin', 'samia.elbouche@laposte.net', '$2y$10$P/rM3zBje1Qq2PaE4GTLnOhlOO5.NS2e1.A71ApyDpnJPBqS/GL5O');