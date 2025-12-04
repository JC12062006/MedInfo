<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/consultations/model.consultations.php';

if(isset($_POST['action'])){
    
    $consultationController = new ConsultationController($bdd);
    
    switch($_POST['action']){

    }


}

class consultationController{

    private $consultation;

    function __construct($bdd)
    {
        $this->consultation = new Consultation($bdd);
    }

    public function create(){

        $this->consultation->ajouterConsultation($_POST['compte_rendu'], $_POST['tension'], $_POST['poids'], $_POST['consultations'], $_POST['id_medecin'],$_POST['id_patient']);
    }
}


?>