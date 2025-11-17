<?php 

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