<?php
require_once ROOT . "model/utilisateur/model.utilisateur.php";
require_once ROOT . "model/patient/model.patient.php";
require_once ROOT . 'mail/resetPasswordMail.php';

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
        case 'mdpOubliee':
            $patientController->motDePasseOublie();
            break;
        case 'reinitMdp':
            $patientController->reinitMdp();
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

        header('Location:https://127.0.0.1/medinfo/index.php?page=connexion');
    }

    public function delete(){

        $this->patient->deleteUtilisateur($_POST['id_utilisateur']);
        header('Location:https://127.0.0.1/medinfo/index.php?page=accueil');
    }

    public function checkLogin(){

        $user = $this->patient->checkLogin($_POST['email'], $_POST['mdp']);
       
        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location:https://127.0.0.1/medinfo/index.php?page=accueil');
            exit;
        } else {
            $_SESSION['login_error'] = "Identifiants incorrects. Veuillez réessayer.";
            header('Location: https://127.0.0.1/medinfo/index.php?page=connexion');
            exit;
        }

    }

    public function update(){

        $this->patient->updatePatient($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['tel'], $_POST['date_naissance'], $_POST['adresse'], $_POST['num_secu'], $_POST['sexe'], $_POST['id_patient'], $_POST['id_utilisateur']);
        header('Location:https://127.0.0.1/stokage/index.php?page=AdminUtilisateur');
    }

    public function motDePasseOublie()
    {

        $email = trim($_POST['email']);

        // 2) Demander au modèle de créer un token
        $token = $this->patient->createResetToken($email);

        if ($token === false) {
            // Aucun compte avec cet email
            $_SESSION['forgot_error'] = "Aucun compte n'est associé à cette adresse e-mail.";
            header('Location: index.php?page=motDePasseOublie');
            exit;
        }

        // ce lien est utilisé dans PHPMailer pour reinitialiser le mdp
        $lienReset = "https://127.0.0.1/medinfo/index.php?page=reinitMdp&token=" . urlencode($token);

        $envoiOK = sendResetEmail($email, $lienReset);

        if ($envoiOK) {
            $_SESSION['forgot_success'] = "Si un compte existe avec cet e-mail, un lien de réinitialisation a été envoyé.";
        } else {
            $_SESSION['forgot_error'] = "L'envoi de l'e-mail a échoué. Veuillez réessayer plus tard.";
        }

        header('Location: index.php?page=mdpOubliee');
        exit;
    }

    public function reinitMdp()
    {

        $token = $_POST['token'];
        $mdp = $_POST['mdp'];
        $mdp2 = $_POST['mdp2'];

        // 2. Vérifier que les deux mots de passe correspondent
        if ($mdp !== $mdp2) {
            $_SESSION['reset_error'] = "Les mots de passe ne correspondent pas.";
            header("Location: index.php?page=reinitMdp&token=" . urlencode($token));
            exit;
        }

        // 3. Vérifier que le token est valide
        $user = $this->patient->verifyResetToken($token);

        if (!$user) {
            $_SESSION['reset_error'] = "Lien expiré ou invalide.";
            header("Location: index.php?page=motDePasseOublie");
            exit;
        }

        // 4. Mettre à jour le mot de passe
        $success = $this->patient->updatePassword($token, $mdp);

        if ($success) {
            $_SESSION['forgot_success'] = "Votre mot de passe a été réinitialisé avec succès !";
            header("Location: index.php?page=connexion");
            exit;
        } else {
            $_SESSION['reset_error'] = "Une erreur est survenue. Veuillez réessayer.";
            header("Location: index.php?page=reinitialisation&token=" . urlencode($token));
            exit;
        }
    }
}


?>