<?php
set_include_path(dirname(__DIR__, 3).'\\vars');
include('db.php');

$link = mysqli_connect($host, $user, $pw, $db) or die ('Erreur '.mysqli_connect_error().get_include_path());
mysqli_set_charset ($link,"utf8");

$mail = $_POST['mail'];
$headers = array(
    'From' => 'noreply@jeannedarc-bretigny.fr',
    'X-Mailer' => 'PHP/' . phpversion()
);
$check = mysqli_query($link ,"SELECT c_mail, c_pw  FROM clients WHERE c_mail='$mail'");
if ($check == "") {	
	echo (str_replace('%corps%', "L'email que vous avez entré est invalide.", file_get_contents('head.html', true)));
} else {
	$mdp = mysqli_fetch_array($check)[1];
	mail($mail, "Réinitialisation de mot de passe", "Votre mot de passe est: ".$mdp.". Pour réinitialiser votre mot de passe, cliquez ici: https://novsite.jeannedarc-bretigny.fr/connexion/mdp_oublie/etape_2/index.php?login=".$mail."&mdp=".$mdp, $headers);
	echo (str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)));
};

mysqli_close($link);
?>