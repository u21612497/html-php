<?php ob_start(); 
session_start();
?>
<?php if (isset($_SESSION['prenom'])) {?>
	<h1>T'es Connecté Bravooo</h1>;
<?php } ?>

<a class="btn my-2 my-sm-0 text-success" href="index.php?action=inscriptionView">ّInscription</a>
<a class="btn my-2 my-sm-0 text-success" href="index.php?action=connexionView">connexion</a>
<a class="btn my-2 my-sm-0 text-success" href="index.php?action=destroy">deconnexion</a>


<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>