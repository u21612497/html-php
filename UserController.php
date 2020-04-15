
<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class UserController 
{

	public function userAll()
	{
		$manager = new UserManager();

		$users = $manager->getUsers();

		require('view/User/userAllView.php');
	}

	public function userProfil()
	{
		session_start();

		$id = $_SESSION['uid'];
		$manager = new UserManager();

		$user = $manager->get($id);

		require('view/User/userProfilView.php');
	}

	public function userSuppr()
	{
		session_start();

		if (!empty($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') 
		{
			$manager = new UserManager();

			$id = $_GET['id'];

			$user = $manager->get($id);

			$manager->delete($user);

			header("Location: index.php?action=userAll");
			exit;
		}
		else
		{
            echo('pb');
            die;
			header("Location: index.php?action=dashboard");
			exit;
		}
	}

	//Connexion
	public function modifierUser()
	{
        $manager = new UserManager();
		$id = $_GET['id'];
		$user = $manager->get($id);

		if ($user->login() != $_POST['login']) {

			$postlogin = $_POST['login'];

			$loginExist = $manager->loginExist($postlogin);

			if ($loginExist != 0) //Vérification si le mail existe
			{
				header("Location: index.php?action=modifierUserView&id=".$id."&error=1");
				exit;
			}
		}
		if(!empty($_POST['mdp']))
		{

			if($_POST['mdp'] == $_POST['mdpConfirm'])
			{

				$user = new User([
				'uid' => $_GET['id'],
				'login' => $_POST['login'],
				'nom' =>  $_POST['nom'],
				'prenom' =>  $_POST['prenom'],
				'mdp' =>  $_POST['mdp'],
				]);

				$manager->update($user);

				header("Location: index.php?action=indexView");
				exit;
			}
			else
			{
				header("Location: index.php?action=modifierUserView&id=".$id."&error=2");
				exit;
            }
		}
		else
		{
			$user = new User([
			'uid' => $_GET['id'],
			'login' => $_POST['login'],
			'nom' =>  $_POST['nom'],
			'prenom' =>  $_POST['prenom'],
			]);

			$manager->updateNoMdp($user);

			header("Location: index.php?action=dashboard");
			exit;

		}
    }

    public function modifierUserView()
	{
        if (!empty($_GET['id'])) 
		{
			$manager = new UserManager();
			$id = $_GET['id'];

			$user = $manager->get($id);

			$updateUid = $user->uid();
			$updateLogin = $user->login();
			$updateNom = $user->nom();
			$updatePrenom = $user->prenom();

			require('view/User/userModiferView.php');

		}
		else
		{
			throw new Exeption("Error Processing Request");
		}
    }
}