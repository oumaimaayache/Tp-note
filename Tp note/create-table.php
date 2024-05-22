
<?php
require_once 'connexion.php.php';
try{
    $sql='CREATE TABLE compteadmin(
        loginAdmin VARCHAR(10) PRIMARY KEY,
        motPasse VARCHAR(10),
        nom VARCHAR(20),
        prenom VARCHAR(20)
    );
    CREATE TABLE filiere (
        idFiliere VARCHAR(5) PRIMARY KEY,
        intitule VARCHAR(20),
        nombtreGroupe int(11)
    );
    CREATE TABLE stagiaire (
        idstagiaire int(11) PRIMARY KEY,
        nom VARCHAR(20),
        prenom VARCHAR(20),
        dateNaissance date ,
        idFiliere VARCHAR(5),
        FOREIGN KEY (idFiliere) REFERENCES filiere(idFiliere)
    );
 
    ';
    $pdo->exec($sql);
    echo'les tables est crée avec succées';
}
 
    catch(PDOException $e){
        echo'erreur :'.$e->getMessage();
    }
 
 
 
 
 
 
 
 
 
 
?>