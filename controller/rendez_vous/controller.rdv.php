<?php

require_once ROOT . 'bdd/bdd.php';
require_once ROOT . 'model/rendez_vous/model.rdv.php';

if(isset($_POST['action'])){

    $rdvController = new RdvController($bdd);

    switch($_POST['action']){

        case 'ajouter':
            $rdvController->create();
            break;

        case 'supprimer':
            $rdvController->delete();
            break;

        // Tu pourras ajouter d'autres cas si besoin (modifier, annuler, etc.)
    }
}

class RdvController{

    private $rdv;

    function __construct($bdd)
    {
        $this->rdv = new Rendez_vous($bdd);
    }

    // ➕ Ajouter un rendez-vous
    public function create(){
        $this->rdv->ajouterRdv(
            $_POST['motif'], 
            $_POST['origine'], 
            $_POST['id_patient'], 
            $_POST['id_creneau']
        );

        // Après ajout, redirection vers la liste des rendez-vous du patient
        header('Location:https://127.0.0.1/promo300/medinfo/index.php?page=rdvPatient');
        exit;
    }

    // ❌ Supprimer un rendez-vous
    public function delete(){
        $this->rdv->supprimerRdv($_POST['id_rdv']);

        // Après suppression, redirection vers la liste des rendez-vous du patient
        header('Location:https://127.0.0.1/promo300/medinfo/index.php?page=rdvPatient');
        exit;
    }

    // 📋 Lister les rendez-vous du patient
    public function listPatient($id_utilisateur){
        return $this->rdv->getAllRdvPatient($id_utilisateur);
    }

    // 📋 Lister les rendez-vous du médecin
    public function listMedecin($id_utilisateur){
        return $this->rdv->getAllRdvMedecin($id_utilisateur);
    }

    // 🔎 Récupérer les créneaux disponibles
    public function listCreneaux(){
        return $this->rdv->getCreneauxDisponibles();
    }
}
