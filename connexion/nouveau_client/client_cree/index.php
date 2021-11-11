<?php
$mail=$_POST['mail'];
$mdp=$_POST['mdp1'];
$check=$_POST['mdp2'];
$num=$_POST['tel'];
if ($mdp !== $check) {
	header("Location: https://novsite.jeannedarc-bretigny.fr/connexion/nouveau_client/index.php"); // Redirection du navigateur
	// Assurez-vous que la suite du code ne soit pas exécutée une fois la redirection effectuée. 
	exit;
} else {
	set_include_path(dirname(__DIR__, 3).'\\vars');
	include('db.php');
		   
	$link = mysqli_connect($host, $user, $pw, $db) or die ('Erreur '.mysqli_connect_error());

	$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
	$hidden = "";  // STR à injecter dans le HTML pour le stockage de la commande
	while ($produit=mysqli_fetch_array($check)) {
		$hidden .= "<input type='hidden' value='".strval($_POST['n'.strval($produit[0])])."' name='n".$produit[0]."'>";
	};
	
	mysqli_query($link, "INSERT INTO clients (c_mail, c_pw, c_etat, c_num_tel) VALUES ('$mail', '$mdp', '1', '$num')");
	echo(str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true))));
	mysqli_close($link);
};
?>