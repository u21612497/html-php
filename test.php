
<?php

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

$req=$bdd->prepare('INSERT INTO user(nom)VALUES(?)');
$req->execute( array($_POST['user']) );

?>
 
