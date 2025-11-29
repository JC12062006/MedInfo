<?php
require_once ROOT . "model/utilisateur/model.utilisateur.php";
require_once ROOT . "model/patient/model.patient.php";

require_once ROOT . "bdd/bdd.php";

//var_dump($_POST);
//die();


if(isset($_POST['action'])){

    $patientController = new patientController($bdd);

    switch($_POST['action']){

        case 'ajouter':
            $patientController->create();
            break;
        case 'supprimer':
            $patientController->delete();
            break;
        case 'modifier':
            $patientController->update();
            break;
        case 'connexion':
            $patientController->checkLogin();
            break;
                
    }
}

class patientController{

    private $patient;

    function __construct($bdd)
    {
        $this->patient = new Patient($bdd);
    }

    public function create(){
        $this->patient->createPatient($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp'], $_POST['tel'], $_POST['date_naissance'], $_POST['adresse'], $_POST['num_secu'], $_POST['sexe']);

        header('Location:https://127.0.0.1/medinfo/index.php?page=Connexion');
    }

    public function delete(){

        $this->patient->deleteUtilisateur($_POST['id_utilisateur']);
        header('Location:https://127.0.0.1/medinfo/index.php?page=Accueil');
    }

    public function checkLogin(){

        $user = $this->patient->checkLogin($_POST['email'], $_POST['mdp']);
       
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location:https://127.0.0.1/stokage/index.php?page=Accueil');
            exit;
        } else {
            echo '<div class="Alert_connexion">
                    <p>' . htmlspecialchars($_POST["email"]) . ' n\'est associé à aucun compte actif, veuillez contacter votre administrateur.</p>
                </div>';
        }

    }

    public function update(){

        $this->patient->updatePatient($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['tel'], $_POST['date_naissance'], $_POST['adresse'], $_POST['num_secu'], $_POST['sexe'], $_POST['id_patient'], $_POST['id_utilisateur']);
        header('Location:https://127.0.0.1/stokage/index.php?page=AdminUtilisateur');
    }
}


?>