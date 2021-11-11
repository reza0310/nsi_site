<?php
set_include_path(dirname(__DIR__, 2)."\\vars");
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db);

$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
$hidden = "";  // STR à injecter dans le HTML pour le stockage de la commande
while ($produit=mysqli_fetch_array($check)) {
	$hidden .= "<input type='hidden' value='".strval($_POST['n'.strval($produit[0])])."' name='n".$produit[0]."'>";
};

echo (str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true))));
?>