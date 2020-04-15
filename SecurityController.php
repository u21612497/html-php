<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class SecurityController 
{
	//Connexion
	public function connexion()
	{

		$user = new UserManager();

		$getLogin = $user->getLogin($_POST['login']);

		if (!$getLogin) 
		{
			header("Location: index.php?action=connexionView&error=1");
			exit;
		}
		else
		{

			$user = $user->connect($_POST['login']);

			$isPasswordCorrect = password_verify($_POST['mdp'], $user->mdp());

			if ($isPasswordCorrect) {
				session_start();

				$_SESSION['nom'] = htmlspecialchars($user->nom());
				$_SESSION['prenom'] = htmlspecialchars($user->prenom());	
				$_SESSION['uid'] = $user->uid();
				$_SESSION['role'] = $user->role();

				require('view/indexView.php');

				return $user;
				return $isPasswordCorrect;
			}
			else 
			{
				header("Location: index.php?action=connexionView&error=2");
				exit;
			}
		}
	}
	
	public function connexionView()
	{
		require('view/Security/connexionView.php');
	}

	public function dashboard()
	{
		require('view/dashboardView.php');
	}
    
	//Déconnexion
	public function destroy()
	{
		session_start();
		session_destroy();
		header("Location: index.php");
		exit;
	}

	//Traitement formulaire inscription
	public function inscription()
	{
		$manager = new UserManager();

		$postLogin = $_POST['login'];

		$loginExist = $manager->loginExist($postLogin);

		if ($loginExist != 0) //Vérification si le pseudo existe
		{
			header("Location: index.php?action=inscriptionView&error=1");
			exit;
		}

		elseif($_POST['mdp'] == $_POST['mdpConfirm'])
		{
			$user = new User([
			'login' => $_POST['login'],
			'nom' =>  $_POST['nom'],
			'prenom' =>  $_POST['prenom'],
			'mdp' =>  $_POST['mdp'],
			'role' => 'user',
			]);

			$manager->add($user);

			header("Location: /index.php?action=connexionView");
			exit;
		}
		else
		{
			header("Location: index.php?action=inscriptionView&error=2");
			exit;
		}
	}

	//Formulaire inscription
	public function inscriptionView()
	{
		require('view/View/InscriptionView.php');
	}

	//Page d'Accueil
	public function index()
	{
		require('view/indexView.php');
    }
	
}