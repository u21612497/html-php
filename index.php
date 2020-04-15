<?php
//Autoloader
/* spl_autoload_register(function ($class_name) {
	include 'controller/' . $class_name . '.php';
});
 */

include 'controller/SecurityController.php';
include 'controller/ProjetController.php';
include 'controller/GroupeController.php';
include 'controller/AssociationController.php';
include 'controller/DemandeController.php';
include 'controller/ChoixController.php';
include 'controller/AffectationController.php';
include 'controller/UserController.php';
//Routeur
try {
	$controllerFirst = new SecurityController;
	$controllerSecond = new ProjetController;
	$controllerThird = new GroupeController;
	$controllerFourth = new AssociationController;
	$controllerFive = new DemandeController;
	$controllerSix = new ChoixController;
	$controllerSeven = new AffectationController;
	$controllerEight = new UserController;
	
	if (!empty($_GET['action'])) {
		$action = $_GET['action'];
		if (method_exists($controllerFirst, $action)) {
            $controllerFirst->$action();
        } elseif (method_exists($controllerSecond, $action)) {
			$controllerSecond->$action();
		} elseif (method_exists($controllerThird, $action)) {
			$controllerThird->$action();
		} elseif (method_exists($controllerFourth, $action)) {
			$controllerFourth->$action();
		} elseif (method_exists($controllerFive, $action)) {
			$controllerFive->$action();
		} elseif (method_exists($controllerSix, $action)) {
			$controllerSix->$action();
		} elseif (method_exists($controllerSeven, $action)) {
			$controllerSeven->$action();
		} elseif (method_exists($controllerEight, $action)) {
			$controllerEight->$action();
		}
	} else {
		$controllerFirst->index();
	}
} catch (Exeption $e) {
	die('Erreur : ' . $e->getMessage());
}