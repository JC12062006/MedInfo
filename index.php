<?php 

define('ROOT', __DIR__ . '/');

session_start();

require_once("view/commun/header.php");
$page = isset($_GET['page']) ? $_GET['page'] : 'Accueil';

switch($page){

    case 'dashboardMedecin' :
        require_once("view/medecin/dashboardMedecin.php");
        break;
    case 'demandesRdv' :
        require_once("view/medecin/demandesRdv.php");
        break;
    case 'disponibilites' :
        require_once("view/medecin/disponibilites.php");
        break;
    case 'connexion' :
        require_once("view/utilisateur/connexion.php");
        break;
    case 'inscription' :
        require_once("view/utilisateur/inscription.php");
        break;
    case 'controllerPatient' :
        require_once("controller/patient/controller.patient.php");
        break;
    case 'mdpOubliee' :
        require_once("view/utilisateur/mdpOubliee.php");
        break;
    case 'reinitMdp' :
        require_once("view/utilisateur/reinitialisationMdp.php");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
    case '' :
        require_once("");
        break;
}

require_once("view/commun/footer.php");

?>