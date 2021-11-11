<?php
set_include_path(dirname(__DIR__, 1).'\\vars');
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db);

$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
$hidden = "";  // STR à injecter dans le HTML pour le stockage de la commande
$nbre_articles = 0;
while ($produit=mysqli_fetch_array($check)) {
	$v = strval($_POST['n'.strval($produit[0])]);
	$hidden .= "<input type='hidden' value='".$v."' name='n".$produit[0]."'>";
	if ($v != '0') {
		$nbre_articles = 1;
	};
};

if ($nbre_articles == 0) {
	echo (str_replace('/commande/horaires/', '/mon_compte/', str_replace('%hidden%', "", str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)))));
} else {
	echo (str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true))));
};

mysqli_close();
?>