<?php

class Utilisateur{

    private $bdd;

    function __construct($bdd)
    {
        $this->bdd=$bdd;
    }

    public function createUtilisateur($nom, $prenom, $email, $mdp, $tel, $role, $date_naissance){

        $hashmdp = sha1($mdp);
        $req = $this->bdd->prepare("INSERT INTO utilisateur(nom, prenom, email, hash_password, telephone, role, date_naissance) VALUES (:nom, :prenom, :email, :mdp, :tel, :role, :date_naissance)");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashmdp);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':role', $role);
        $req->bindParam(':date_naissance', $date_naissance);
               
        return $req->execute();
    }

    public function checkLogin($email, $mdp){
        $hashmdp = sha1($mdp);
        $req = $this->bdd->prepare("SELECT * FROM utilisateur WHERE email= :email AND hash_password= :mdp");
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashmdp);  
        $req->execute();
        return $req->fetchAll();
    }


    public function readUtilisateur(){

        $req = $this->bdd->prepare("SELECT * FROM utilisateur");
        $req->execute();

        return $req->fetchAll();
    }

    public function updateUtilisateur($nom, $prenom, $email, $mdp, $tel, $date_naissance, $id_utilisateur){

        $hashmdp = sha1($mdp);
        $req = $this->bdd->prepare("UPDATE utilisateur SET nom = :nom, prenom = :prenom, email= :email, hash_password = :mdp, telephone = :tel, date_naissance = :date_naissance WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $hashmdp);
        $req->bindParam(':tel', $tel);
        $req->bindParam(':date_naissance', $date_naissance);
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }

    public function deleteUtilisateur($id_utilisateur){

        $req = $this->bdd->prepare("DELETE FROM utilisateur WHERE id_utilisateur = :id_utilisateur");
        $req->bindParam(':id_utilisateur', $id_utilisateur);

        return $req->execute();
    }
}   