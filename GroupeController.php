<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class GroupeController
{

    public function groupeAll()
	{
		$manager = new GroupeManager();

		$groupes = $manager->getGroupes();

		require('view/Groupe/groupeAllView.php');
	}

    public function ajouterGroupe()
    {
        $manager = new GroupeManager();

        $groupes = new Groupe([
            'pid' => $_POST['pid'],
        ]);

        $manager->add($groupes);

        header("Location: /index.php?action=GroupeAll");
        exit;
    }

    public function ajouterGroupeView()
    {
        $manager = new ProjetManager;

        $projets = $manager->getProjets();

        require('view/Groupe/ajouterGroupeView.php');
    }

    public function groupeModifier()
    {
        session_start();
        
        $manager = new GroupeManager();

        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php");
            exit;
        } else {
            $groupe = new Groupe([
                'gid' => $_GET['id'],
                'pid' => $_POST['pid']
            ]);

            $manager->update($groupe);

            header("Location: index.php?action=groupeAll");
            exit;
        }
    }

    public function groupeModifierView()
    {

        if (!empty($_GET['id'])) {

            $manager = new GroupeManager();

            $groupe = $manager->get($_GET['id']);
            
            if ($_SESSION['role'] != 'admin') {
                $updateGid = $groupe->gid();
                $updatePid = $groupe->pid();

                $managerp = new ProjetManager();
                $projet = $managerp->get($updatePid);
                $projets = $managerp->getProjets();

                require('view/Groupe/groupeModifierView.php');
            }
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function groupeSuppr()
	{
		session_start();

		if (!empty($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') 
		{
			$manager = new GroupeManager();

			$id = $_GET['id'];

			$groupe = $manager->get($id);

			$manager->delete($groupe);

			header("Location: index.php?action=groupeAll");
			exit;
		}
		else
		{
			header("Location: index.php");
			exit;
		}
	}
}
