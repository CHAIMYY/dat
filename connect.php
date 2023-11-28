<?php
$serveur="localhost";
$nomBD="breif6";
$login="root";
$password="";
    


$connexion = mysqli_connect($serveur, $login, $password, $nomBD);

if (!$connexion) {
    die("Connection failed: " . mysqli_connect_error());
}


// Fermer la connexion



?> 