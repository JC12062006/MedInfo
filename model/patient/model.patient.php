<?php

class Patient extends Utilisateur
{
    private $bdd;

    public function __construct($bdd)
    {
        // On appelle le constructeur de Utilisateur
        parent::__construct($bdd);
        // Et on garde aussi une référence locale si on en a besoin
        $this->bdd = $bdd;
    }

    /**
     * Crée un utilisateur AVEC son profil patient.
     * 1) Insère dans la table utilisateur (rôle = 'Patient')
     * 2) Insère dans la table patient avec id_utilisateur récupéré
     */
    public function createPatient($nom, $prenom, $email, $mdp, $tel, $date_naissance, $adresse, $num_secu, $sexe)
    {

        $role = 'Patient';

        // 1) Création dans la table utilisateur (méthode héritée)
        $userOk = $this->createUtilisateur($nom, $prenom, $email, $mdp, $tel, $role, $date_naissance);
        
        
        if (!$userOk) {
            return false;
        }

        // On récupère l'id_utilisateur inséré juste avant
        $id_utilisateur = $this->bdd->lastInsertId();

        // 2) Création dans la table patient
        $req = $this->bdd->prepare("
            INSERT INTO patient (adresse, num_secu, sexe, id_utilisateur)
            VALUES (:adresse, :num_secu, :sexe, :id_utilisateur)
        ");
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':num_secu', $num_secu);
        $req->bindParam(':sexe', $sexe);
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }

    /**
     * Lire tous les patients (simple SELECT *)
     */
    public function readPatient()
    {
        $req = $this->bdd->prepare("SELECT * FROM patient");
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Mettre à jour les infos patient (PAS les infos utilisateur ici)
     */
    public function updatePatient($adresse, $num_secu, $sexe, $id_patient)
    {
        $req = $this->bdd->prepare("
            UPDATE patient
            SET adresse = :adresse,
                num_secu = :num_secu,
                sexe = :sexe
            WHERE id_patient = :id_patient
        ");
        $req->bindParam(':adresse', $adresse);
        $req->bindParam(':num_secu', $num_secu);
        $req->bindParam(':sexe', $sexe);
        $req->bindParam(':id_patient', $id_patient);

        return $req->execute();
    }

    /**
     * Supprime un patient (ligne dans patient uniquement)
     * Si tu as ON DELETE CASCADE sur la FK id_utilisateur,
     * tu peux décider de supprimer d'abord l'utilisateur.
     */
    public function deletePatient($id_patient)
    {
        $req = $this->bdd->prepare("DELETE FROM patient WHERE id_patient = :id_patient");
        $req->bindParam(':id_patient', $id_patient);

        return $req->execute();
    }
}


?>