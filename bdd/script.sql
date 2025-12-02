DROP DATABASE IF EXISTS medinfo;

CREATE DATABASE medinfo;

USE medinfo;

-- table utilisateur
CREATE TABLE utilisateur(
   
    id_utilisateur          INT AUTO_INCREMENT PRIMARY KEY,
    nom                     VARCHAR(155)       NOT NULL,
    prenom                  VARCHAR(155)       NOT NULL,
    email                   VARCHAR(155)       NOT NULL UNIQUE,
    hash_password           VARCHAR(255)       NOT NULL,
    date_creation           TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    telephone               VARCHAR(20)        NOT NULL UNIQUE,
    role                    ENUM('Admin','Patient','Medecin','Secretaire') NOT NULL,
    date_naissance          DATE               NOT NULL
    reset_token             VARCHAR(64)        NULL,
    reset_token_expiration  DATETIME           NULL;

);

-- table specialite
CREATE TABLE specialite(
   
    id_specialite INT AUTO_INCREMENT PRIMARY KEY,
    libelle       VARCHAR(155) NOT NULL

);

-- Table medecin
CREATE TABLE medecin(
   
    id_medecin        INT AUTO_INCREMENT PRIMARY KEY,
    rpps              VARCHAR(11)  NOT NULL UNIQUE,
    est_conventionne  BOOLEAN      NOT NULL DEFAULT 1,        
    formations        VARCHAR(155) NOT NULL,
    langues_parlees   VARCHAR(255) NOT NULL,
    experiences       VARCHAR(255) NOT NULL,
    description       VARCHAR(1000) NOT NULL,
    fk_id_utilisateur INT          NOT NULL,
    fk_id_specialite  INT          NOT NULL,
    FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (fk_id_specialite) REFERENCES specialite(id_specialite)

);

-- table patient
CREATE TABLE patient(

    id_patient      INT AUTO_INCREMENT PRIMARY KEY,
    adresse         VARCHAR(255) NOT NULL,
    num_secu        VARCHAR(15)  NOT NULL UNIQUE,
    sexe            ENUM('homme','femme') NULL,
    fk_id_utilisateur INT NOT NULL,
    FOREIGN KEY (fk_id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE

);

-- Table rdv
CREATE TABLE rendez_vous(
   
    id_rdv        INT  AUTO_INCREMENT PRIMARY KEY,
    date_creation DATE NOT NULL,
    motif         VARCHAR(255) NOT NULL,
    statut        ENUM('a_confirmer','confirmé','annulé','honoré','absent') NOT NULL,
    origine       VARCHAR(155) NOT NULL,
    fk_id_patient INT NOT NULL,
    fk_id_medecin INT NOT NULL,
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient),
    FOREIGN KEY (fk_id_medecin) REFERENCES medecin(id_medecin)

);

-- Table salle
CREATE TABLE salle(

    id_salle   INT  AUTO_INCREMENT PRIMARY KEY,
    libelle   VARCHAR(50) NOT NULL,
    etage      VARCHAR(50) NOT NULL

);

-- Table creneau
CREATE TABLE creneau(
   
    id_creneau       INT AUTO_INCREMENT PRIMARY KEY,
    date_heure_debut DATETIME NOT NULL,
    date_heure_fin   DATETIME NOT NULL,
    statut           ENUM('libre','occupe','bloque') NOT NULL,
    disponibilite    BOOLEAN NOT NULL DEFAULT 1,
    fk_id_medecin    INT NOT NULL,
    FOREIGN KEY (fk_id_medecin) REFERENCES medecin(id_medecin),
    fk_id_salle      INT NOT NULL,
    FOREIGN KEY (fk_id_salle) REFERENCES salle(id_salle)

);

-- Table consultations
CREATE TABLE consultations(

    id_consultation INT  AUTO_INCREMENT PRIMARY KEY,
    date_saisie     TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
    compte_rendu    VARCHAR(1000)       NOT NULL,
    tension         VARCHAR(55)         NOT NULL,
    poids           VARCHAR(55)         NOT NULL,
    observations    VARCHAR(1000),
    fk_id_medecin   INT                 NOT NULL,
    fk_id_patient   INT                 NOT NULL,
    FOREIGN KEY (fk_id_medecin) REFERENCES medecin(id_medecin),
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient)
);

-- Table documentation
CREATE TABLE documentation(

    id_document   INT AUTO_INCREMENT PRIMARY KEY,
    document      MEDIUMBLOB         NOT NULL,
    libelle       VARCHAR(100)       NOT NULL,
    fk_id_patient INT                NOT NULL,
    FOREIGN KEY (fk_id_patient) REFERENCES patient(id_patient)

);


-- jeux de données pour alimenter la BDD
INSERT INTO specialite (libelle) VALUES
('Cardiologie'),
('Dermatologie'),
('Gynécologie'),
('Pédiatrie'),
('Neurologie'),
('Endocrinologie'),
('Rhumatologie'),
('Gastro-entérologie'),
('Pneumologie'),
('Oncologie'),
('Urologie'),
('Psychiatrie'),
('ORL'),
('Ophtalmologie'),
('Chirurgie générale'),
('Médecine générale'),
('Médecine du sport'),
('Allergologie'),
('Hématologie'),
('Médecine interne');


INSERT INTO utilisateur (nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES 
('Dupont', 'Camille', 'c.dupont@medinfo.fr', SHA1('Medinfo123'), '0601020304', 'Medecin', '1978-04-12'),
('Martin', 'Sarah', 's.martin@medinfo.fr', SHA1('Dermato2024'), '0611223344', 'Medecin', '1985-06-22'),
('Benali', 'Mohamed', 'm.benali@medinfo.fr', SHA1('Generaliste77'), '0677889900', 'Medecin', '1975-11-03'),
('Romano', 'Elisa', 'e.romano@medinfo.fr', SHA1('Gyneco2025'), '0655443322', 'Medecin', '1984-02-14'),
('Caron', 'Julien', 'j.caron@medinfo.fr', SHA1('Pediatrie01'), '0644221133', 'Medecin', '1983-09-17');

INSERT INTO medecin (rpps, formations, langues_parlees, experiences, description, fk_id_utilisateur, fk_id_specialite) VALUES 
('12345678901', 'DES Cardiologie', 'Français, Anglais', '15 ans en CHU', 'Spécialiste du cœur, diagnostic rapide et prise en charge complète.', 1, 1),
('23456789012', 'DES Dermatologie', 'Français, Anglais, Espagnol', '10 ans cabinet privé', 'Experte en maladies de peau, traitements laser et esthétique médicale.', 2, 2),
('34567890123', 'Doctorat Médecine Générale', 'Français, Arabe', '20 ans de pratique', 'Médecin généraliste expérimenté, suivi complet et prévention.', 3, 16),
('45678901234', 'DES Gynécologie Obstétrique', 'Français, Italien', '12 ans maternité niveau 3',    'Spécialiste du suivi de grossesse, fertilité et santé féminine.', 4, 3),
('56789012345', 'DES Pédiatrie', 'Français, Anglais', '9 ans en pédiatrie hospitalière', 'Pédiatre attentionné, suivi de l’enfant et de l’adolescent.', 5, 4);
