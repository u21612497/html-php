<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class ChoixController
{
    public function choixAll()
	{
		$manager = new ChoixManager();

		$achoix = $manager->getChoix();

		require('view/Choix/choixAllView.php');
	}

    public function ajouterChoix()
    {
        $manager = new ChoixManager();

        $choix = new Choix([
            'nom' => $_POST['nom'],
            'pid' => $_POST['pid'],
        ]);

        $manager->add($choix);

        header("Location: /index.php?action=ajouterChoixView");
        exit;
    }

    public function ajouterChoixView()
    {
        $managerG = new GroupeManager;
        $managerP = new ProjetManager;

        $groupes = $managerG->getgroupes();
        $projets = $managerP->getProjets();
        
        require('view/Choix/ajouterChoixView.php');
    }

    public function choixModifier()
    {
        session_start();
        
        $manager = new choixManager();

        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php");
            exit;
        } else {
            $choix = new choix([
                'cid' => $_GET['id'],
                'nom' => $_POST['nom'],
                'pid' => $_POST['pid']
            ]);

            $manager->update($choix);

            header("Location: index.php?action=choixAll");
            exit;
        }
    }

    public function choixModifierView()
    {

        if (!empty($_GET['id'])) {

            $manager = new choixManager();

            $choix = $manager->get($_GET['id']);
            
            if ($_SESSION['role'] != 'admin') {
                $updateGid = $choix->cid();
                $updateNom = $choix->nom();
                $updatePid = $choix->pid();

                $managerp = new ProjetManager();
                $projet = $managerp->get($updatePid);
                $projets = $managerp->getProjets();

                require('view/Choix/choixModifierView.php');
            }
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function choixSuppr()
	{
		session_start();

		if (!empty($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') 
		{
			$manager = new choixManager();

			$id = $_GET['id'];

			$choix = $manager->get($id);

			$manager->delete($choix);

			header("Location: index.php?action=choixAll");
			exit;
		}
		else
		{
			header("Location: index.php");
			exit;
		}
	}
}
