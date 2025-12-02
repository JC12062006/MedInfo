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
INSERT INTO specialite (id_specialite, libelle) VALUES
(1,  'Médecine générale'),
(2,  'Cardiologie'),
(3,  'Dermatologie'),
(4,  'Gynécologie'),
(5,  'Pédiatrie'),
(6,  'Oto-rhino-laryngologie (ORL)'),
(7,  'Ophtalmologie'),
(8,  'Rhumatologie'),
(9,  'Endocrinologie'),
(10, 'Gastro-entérologie'),
(11, 'Pneumologie'),
(12, 'Neurologie'),
(13, 'Psychiatrie'),
(14, 'Urologie'),
(15, 'Néphrologie'),
(16, 'Oncologie'),
(17, 'Gériatrie'),
(18, 'Allergologie'),
(19, 'Radiologie'),
(20, 'Médecine du sport');


INSERT INTO utilisateur 
(id_utilisateur, nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES
(100, 'Dupont',  'Marie',   'marie.dupont@medinfo.fr',  'e937073df714290723d91595945f9359cedaf69e', '0600000001', 'medecin', '1980-03-12'),
(101, 'Martin',  'Paul',    'paul.martin@medinfo.fr',   'a007fbfad9cd4a4c8eb330f95266c2655404830b', '0600000002', 'medecin', '1975-07-25'),
(102, 'Leroy',   'Sophie',  'sophie.leroy@medinfo.fr',  '91b6657ccd7093b33caabeeda4bc7b12ccd387c8', '0600000003', 'medecin', '1983-11-05'),
(103, 'Rossi',   'Alessio', 'alessio.rossi@medinfo.fr', 'a176fa6083c16c5ce397b0a2582fc8930011c6c7', '0600000004', 'medecin', '1978-02-18'),
(104, 'Nguyen',  'Linh',    'linh.nguyen@medinfo.fr',   '39663005e9ffd5d604bde4c2f093b21b94e1c8a8', '0600000005', 'medecin', '1986-09-09');

INSERT INTO medecin 
(id_medecin, id_utilisateur, id_specialite, numero_rpps, salle_cabinet) VALUES
(1, 100, 1, '10000000001', 'Cabinet 101'),
(2, 101, 2, '10000000002', 'Cabinet 202'),
(3, 102, 3, '10000000003', 'Cabinet 303'),
(4, 103, 4, '10000000004', 'Cabinet 404'),
(5, 104, 5, '10000000005', 'Cabinet 505');
