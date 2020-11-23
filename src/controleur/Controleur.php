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
?>
