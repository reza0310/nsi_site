<?php
$mail = $_POST["mail"];
$ancien_mdp = $_POST["pw"];
$mdp = $_POST["pw1"];
$check = $_POST["pw2"];

if ($mdp !== $check) {
	header("Location: https://novsite.jeannedarc-bretigny.fr/connexion/mdp_oublie/etape_2/index.php?login=$mail&mdp=$ancien_mdp"); // Redirection du navigateur
	// Assurez-vous que la suite du code ne soit pas exécutée une fois la redirection effectuée. 
	exit;
} else {
	set_include_path(dirname(__DIR__, 3).'\\vars');
	include('db.php');
	$link = mysqli_connect($host, $user, $pw, $db) or die ('Erreur '.mysqli_connect_error());
	mysqli_set_charset ($link,"utf8");
	$change_etat = mysqli_query($link ,"UPDATE clients SET c_pw = '$mdp' WHERE c_mail='$mail' AND c_pw='$ancien_mdp'");
	echo(str_replace('%php2%', $pass, str_replace('%php%', $mail, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)))));
};
?>