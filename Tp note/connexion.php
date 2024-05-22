<?php
$host = 'localhost';
$dbname='gestionstagiaire_v1';
$username='root';
$password='';
try {
    $con = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    // echo "connexion effectuée avec succes";
} catch (PDOException $e) {
 die('Erreur: '.$e->getMessage());

}

?>