<?php

spl_autoload_register(function ($class_name) {
    include 'model/' . $class_name . '.php';
});
include 'model/ProjetManager.php';

class ProjetController
{
    public function projetAll()
    {
        $manager = new projetManager();

        $projets = $manager->getprojets();

        require('view/Projet/projetAllView.php');
    }

    public function ajouterProjet()
    {
        $manager = new ProjetManager();

        if ($_POST['dateDebut'] > $_POST['dateFin']) {
            header("Location: index.php?action=ajouterProjetView&error=1");
            exit;
        } else {
            $projets = new Projet([
                'titre' => $_POST['titre'],
                'description' =>  $_POST['description'],
                'tailleGroupe' =>  $_POST['tailleGroupe'],
                'dateDebut' =>  $_POST['dateDebut'],
                'dateFin' =>  $_POST['dateFin'],
            ]);

            $manager->add($projets);

            header("Location: /index.php?action=projetGetView");
            exit;
        }
    }

    public function ajouterProjetView()
    {
        require('view/Projet/ajouterProjetView.php');
    }

    public function projetFullView()
    {
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $manager = new projetManager();

            $projet = $manager->get($id);

            require('view/Projet/projetFullView.php');
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function projetModifier()
    {
        $manager = new ProjetManager();

        if ($_POST['dateDebut'] > $_POST['dateFin']) {
            header("Location: index.php?action=projetModifierView&id=" . $_GET['id'] . "&error=1");
            exit;
        } else {
            $projet = new Projet([
                'pid' => $_GET['id'],
                'titre' => $_POST['titre'],
                'description' =>  $_POST['description'],
                'tailleGroupe' =>  $_POST['tailleGroupe'],
                'dateDebut' => $_POST['dateDebut'],
                'dateFin' => $_POST['dateFin']
            ]);

            $manager->update($projet);

            header("Location: index.php?action=projetAll");
            exit;
        }
    }

    public function projetModifierView()
    {

        if (!empty($_GET['id'])) {
            $manager = new ProjetManager();

            $blogp = $manager->get($_GET['id']);

            $updatePid = $blogp->pid();
            $updateTitre = $blogp->titre();
            $updateDescription = $blogp->description();
            $updateTailleGroupe = $blogp->tailleGroupe();
            $updateDateDebut = $blogp->dateDebut();
            $updateDateFin = $blogp->dateFin();

            require('view/Projet/projetModifierView.php');
        } else {
            throw new Exception("Error Processing Request");
        }
    }

    public function projetUser()
    {
        session_start();

        $groupeManager = new groupeManager();
        $projetManager = new projetManager();
        $userManager = new userManager();
        $associationManager = new AssociationManager();

        $uid = $_SESSION['uid'];

        $user = $userManager->get($uid);
        $association = $associationManager->getByUser($user);
        $groupe = $groupeManager->getByAssociation($association);
        $projet = $projetManager->get($groupe->pid());
        
        require('view/Projet/projetFullView.php');
    }
}
