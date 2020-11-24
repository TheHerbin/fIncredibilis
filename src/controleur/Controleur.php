<?php
function accueilControleur($twig){
    echo $twig->render('accueil.html.twig', array());
}

function creerUtilisateurControleur($twig,$db){
    $form = array();
    if (isset($_POST['envoyer'])){
        $email = $_POST['email'];
        $motdepasse = $_POST['motdepasse'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $tel = $_POST['tel'];
        $idrole = $_POST['idrole'];
        $form['valide'] = true;
        $form['email'] = $email;
        $form['role'] = $idrole;
        $Utilisateur = new Utilisateur($db);
            $exec = $Utilisateur->insert($nom, $prenom, $email, password_hash($motdepasse,PASSWORD_DEFAULT), $tel, $idrole);
            if (!$exec){
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
        }
        $form['email'] = $email;
        $form['idrole'] = $idrole;
      }
    echo $twig->render('creerUtilisateur.html.twig', array('form'=>$form));
   }

   function connexionControleur($twig, $db){
    $form = array();

    if (isset($_POST['valider'])){
    $form['valide'] = true;
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $utilisateur = new Utilisateur($db);
    $unUtilisateur = $utilisateur->connect($email);
    if ($unUtilisateur!=null){
    $mdpH = password_hash($mdp,PASSWORD_DEFAULT);
    if(!password_verify($mdp,$unUtilisateur['motdepasse'])){
        $form['valide'] = false;
 $form['message'] = 'Login ou mot de passe incorrect';
 }
 else{
    $_SESSION['login'] = $email;
    $_SESSION['role'] = $unUtilisateur['idrole'];
 header("Location:index.php");
 }
 }
 else{
 $form['valide'] = false;
 $form['message'] = 'Login ou mot de passe incorrect';

 }
 }
 echo $twig->render('connexion.html.twig', array('form'=>$form));
}

function deconnexionControleur($twig, $db){
    session_unset();
 session_destroy();
 header("Location:index.php");
}

function modifUtilisateurControleur($twig, $db){
    $form = array();
 if(isset($_GET['email'])){
 $utilisateur = new Utilisateur($db);
 $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
 
 if ($unUtilisateur!=null){
 $form['utilisateur'] = $unUtilisateur;
 $role = new Role($db);
 $liste = $role->select();
 $form['roles']=$liste;
 }
 else{
 $form['message'] = 'Utilisateur incorrect';
 }
 }
 else{
 if(isset($_POST['btEnvoyer'])){
 $utilisateur = new Utilisateur($db);
 $nom = $_POST['nom'];
 $email = $_POST['email'];
 $prenom = $_POST['prenom'];
 $idrole = $_POST['idrole'];
 $motdepasse = $_POST['motdepasse'];
 $tel = $_POST['tel'];
 $exec=$utilisateur->update($tel, $idrole, $nom, $prenom, $email, password_hash($motdepasse,PASSWORD_DEFAULT));
 if(!$exec){
 $form['valide'] = false;
 $form['message'] = 'Echec de la modification';
 }
 else{
    $form['valide'] = true;
    $form['message'] = 'Modification réussie';
    }
    }
    else{
    $form['message'] = 'Utilisateur non précisé';
    }
    }
    echo $twig->render('modifUtilisateur.html.twig', array('form'=>$form));
   }

   function maintenanceControleur($twig){
    echo $twig->render('maintenance.html.twig', array());
   }

   function utilisateurControleur($twig, $db){
    
    $form = array();
    $utilisateur = new Utilisateur($db);
    if(isset($_GET['email'])){
       // var_dump($_GET['email']);
        $exec=$utilisateur->delete($_GET['email']);
       // die();
        if (!$exec){
        $etat = false;
        }
        else{
        $etat = true;
        }
        header('Location: index.php?page=utilisateur&etat='.$etat);
        exit;
        }
        if(isset($_GET['etat'])){
        $form['etat'] = $_GET['etat'];
        }
    $liste = $utilisateur->select();

    echo $twig->render('utilisateur.html.twig', array('form'=>$form,'liste'=>$liste));
}

   
function infoControleur($twig){
    echo $twig->render('info.html.twig', array());
   }
?>
