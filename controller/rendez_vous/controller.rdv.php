<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/rendez_vous/model.rdv.php';

if(isset($_POST['action'])){

    $rdvController = new RdvController($bdd);

    switch($_POST['action']){

        case 'ajouter':
            $rdvController->create();
            break;

        case '':

            break;
        case '':
            break;
        case '':
            
            break;
        case '':
            
            break;
    }
}


class RdvController{

    private $rdv;

    function __construct($bdd)
    {
        $this->rdv = new Rendez_vous($bdd);
    }

    public function create(){
        $this->rdv->ajouterRdv($_POST['motif'], $_POST['origine'], $_POST['id_patient'], $_POST['id_creneau']);

        header('Location:https://127.0.0.1/promo300/medinfo/index.php?page=prendreRdv');
    }

}


?>