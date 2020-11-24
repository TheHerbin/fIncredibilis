<?php
function getPage($db){
    var_dump($_GET);
 $lesPages['accueil'] = "accueilControleur";
 $lesPages['creerUtilisateur'] = "creerUtilisateurControleur";
 $lesPages['connexion'] = "connexionControleur";
 $lesPages['deconnexion'] = "deconnexionControleur";
 $lesPages['modifUtilisateur'] = "modifUtilisateurControleur;";
 $lesPages['maintenance'] = "maintenanceControleur";
 $lesPages['utilisateur'] = "utilisateurControleur";
 $lesPages['info'] = "infoControleur";
 $lesPages['maj'] = "majControleur";


 if ($db!=null){
    if (isset($_GET['page'])){
    $page = $_GET['page'];
    }
    else{
    $page = 'accueil';
    }
    if (!isset($lesPages[$page])){
    // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
    $page = 'accueil';
    }
   
    $explose = explode(";",$lesPages[$page]);
    // Nous découpons la ligne du tableau sur le
    //caractère « ; » Le résultat est stocké dans le tableau $explose
   
    $idrole = $explose[1]; // Le rôle est dans la 2ème partie du tableau $explose
   
    if ($idrole != 0){ // Si mon rôle nécessite une vérification
    if(isset($_SESSION['login'])){ // Si je me suis authentifié
    if(isset($_SESSION['idrole'])){ // Si j’ai bien un rôle
    if($idrole!=$_SESSION['idrole']){ // Si mon rôle ne correspond pas à celui qui est nécessaire 
        //pour voir la page
    $contenu = 'accueilControleur'; // Je le redirige vers l’accueil, car il n’a pas le bon rôle
    }
    else{
    $contenu = $explose[0]; // Je récupère le nom du contrôleur, car il a le bon rôle
    }
    }
    else{
    $contenu = 'accueilControleur';;
    }
    }
    else{
    $contenu = 'accueilControleur';; // Page d’accueil, car il n’est pas authentifié
    }
    }else{
    $contenu = $explose[0]; // Je récupère le contrôleur, car il n’a pas besoin d’avoir un rôle
    }
    }
   else{
    $contenu = $lesPages['maintenance'];
   }
   
   
return $contenu;
}

?>

