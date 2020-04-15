<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class AssociationController
{
    public function associationAll()
	{
		$manager = new AssociationManager();

		$associations = $manager->getAssociations();

		require('view/Association/associationAllView.php');
	}

    public function creerAssociation()
    {
        $manager = new AssociationManager();

        $associations = new Association([
            'gid' => $_POST['gid'],
            'uid' => $_POST['uid'],
        ]);

        $manager->add($associations);

        header("Location: /index.php?action=associationAll");
        exit;
    }

    public function creerAssociationView()
    {
        $managerg = new GroupeManager;
        $manageru = new UserManager;

        $groupes = $managerg->getGroupes();
        $users = $manageru->getUsers();
        
        require('view/Association/creerAssociationView.php');
    }

    public function associationModifier()
    {
        session_start();
        
        $manager = new AssociationManager();

        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php");
            exit;
        } else {
            $association = new association([
                'gid' => $_GET['id'],
                'uid' => $_POST['uid']
            ]);

            $manager->update($association);

            header("Location: index.php?action=associationAll");
            exit;
        }
    }

    public function associationModifierView()
    {

        if (!empty($_GET['id'])) {

            $manager = new associationManager();

            $association = $manager->get($_GET['id']);
            
            if ($_SESSION['role'] != 'admin') {
                $updateGid = $association->gid()->gid();
                $updateUid = $association->uid()->uid();

                $managerG = new GroupeManager();
                $groupe = $managerG->get($updateGid);
                $groupes = $managerG->getGroupes();
                
                $managerU = new UserManager();
                $user = $managerU->get($updateUid);
                $users = $managerU->getUsers();

                require('view/association/associationModifierView.php');
            }
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function associationSuppr()
	{
		session_start();

		if (!empty($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') 
		{
			$manager = new associationManager();

			$id = $_GET['id'];

			$association = $manager->get($id);

			$manager->delete($association);

			header("Location: index.php?action=associationAll");
			exit;
		}
		else
		{
			header("Location: index.php");
			exit;
		}
	}
}
