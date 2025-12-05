<?php

class Consultation{

    private $bdd;

    function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function ajouterConsultation($compte_rendu, $tension, $poids, $observations, $id_medecin, $id_patient){

        $req =$this->bdd->prepare("INSERT INTO consultations(compte_rendu, tension, poids, observations, fk_id_medecin, fk_id_patient) VALUES (:compte_rendu, :tension, :poids, :observations, :id_medecin, :id_patient)");

        $req->bindparam(':compte_rendu', $compte_rendu);
        $req->bindparam(':tension', $tension);
        $req->bindparam(':poids', $poids);
        $req->bindparam(':observations', $observations);
        $req->bindparam(':id_medecin', $id_medecin);
        $req->bindparam(':id_patient', $id_patient);

        return $req->execute();
    }

    public function getConsultationsMedecin($id_medecin){

    }

    public function getConsultationsPatient($id_utilisateur){

    }
}


?>