<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
}); 

class AffectationController
{
    public function affectationAll()
	{
		$manager = new AffectationManager();

		$affectations = $manager->getAffectations();

		require('view/affectation/affectationAllView.php');
	}

    public function creerAffectation()
    {
        $manager = new AffectationManager();

        $affectation = new Affectation([
            'gid' => $_POST['gid'],
            'cid' => $_POST['cid'],
        ]);

        $manager->add($affectation);

        header("Location: /index.php?action=affectationAll");
        exit;
    }

    public function creerAffectationView()
    {
        $managerg = new GroupeManager;
        $managerc = new ChoixManager;

        $groupes = $managerg->getGroupes();
        $aChoix = $managerc->getChoix();

        require('view/Affectation/creerAffectationView.php');
    }

    public function affectationModifier()
    {
        session_start();
        
        $manager = new AffectationManager();

        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php");
            exit;
        } else {
            $affectation = new Affectation([
                'gid' => $_GET['id'],
                'cid' => $_POST['cid']
            ]);

            $manager->update($affectation);

            header("Location: index.php?action=affectationAll");
            exit;
        }
    }

    public function affectationModifierView()
    {

        if (!empty($_GET['id'])) {

            $manager = new AffectationManager();

            $affectation = $manager->get($_GET['id']);
            
            if ($_SESSION['role'] != 'admin') {
                $updateGid = $affectation->gid()->gid();
                $updateCid = $affectation->cid()->cid();

                $managerG = new GroupeManager();
                $groupe = $managerG->get($updateGid);
                $groupes = $managerG->getGroupes();
                
                $managerC = new ChoixManager();
                $choix = $managerC->get($updateCid);
                $achoix = $managerC->getChoix();

                require('view/Affectation/affectationModifierView.php');
            }
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function affectationSuppr()
	{
		session_start();

		if (!empty($_GET['id']) && isset($_SESSION['role']) && $_SESSION['role'] == 'admin') 
		{
			$manager = new AffectationManager();

			$id = $_GET['id'];

			$affectation = $manager->get($id);

			$manager->delete($affectation);

			header("Location: index.php?action=affectationAll");
			exit;
		}
		else
		{
			header("Location: index.php");
			exit;
		}
	}
}
