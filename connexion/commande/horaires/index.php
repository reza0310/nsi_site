<?php
set_include_path(dirname(__DIR__, 3).'\\vars');
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db) or die ("Erreur");
$mail = $_POST["mail"];
$mdp = $_POST["mdp"];

$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
$hidden = "<input type='hidden' value='".$mail."' name='mail'><input type='hidden' value='".$mdp."' name='mdp'>";  // STR à injecter dans le HTML pour le stockage de la commande
while ($produit=mysqli_fetch_array($check)) {
	$hidden .= "<input type='hidden' value='".strval($_POST['n'.strval($produit[0])])."' name='n".$produit[0]."'>";
};

$connexion = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM clients WHERE c_mail = '$mail' AND c_pw = '$mdp'"));
if (count($connexion) < 10) {
	echo("T'aurais pas changé un petit truc par hasard? Vous ne passerez pas!");
	/*$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
	$index = 0;  // Index de parcours
	$hidden = "";  // STR à injecter dans le HTML pour le stockage de la commande
	while ($produit=mysqli_fetch_array($check)) {
		$index += 1;  // Index de produit
		$hidden .= "<input type='hidden' value='".strval($_POST['n'.strval($index)])."' name='n".$index."'>";
	};
	//echo ("Commande de ".strval($n1)." éponges, ".strval($n2)." t-shirts et ".strval($n3)." paniers garnis.");
	echo (str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents(dirname(__DIR__, 1).'\\page.html'), file_get_contents('head.html', true))));*/
} else {
	if (getdate()["wday"] < 3) {
		$date_1 = mktime(0, 0, 0, date("m")  , date("d")+4-getdate()["wday"], date("Y"));
		$date_2 = mktime(0, 0, 0, date("m")  , date("d")+5-getdate()["wday"], date("Y"));
		$date_3 = mktime(0, 0, 0, date("m")  , date("d")+11-getdate()["wday"], date("Y"));
		$date_4	= mktime(0, 0, 0, date("m")  , date("d")+12-getdate()["wday"], date("Y"));
	} else {
		$date_1 = mktime(0, 0, 0, date("m")  , date("d")+11-getdate()["wday"], date("Y"));
		$date_2	= mktime(0, 0, 0, date("m")  , date("d")+12-getdate()["wday"], date("Y"));
		$date_3 = mktime(0, 0, 0, date("m")  , date("d")+18-getdate()["wday"], date("Y"));
		$date_4	= mktime(0, 0, 0, date("m")  , date("d")+19-getdate()["wday"], date("Y"));
	};
	echo(str_replace('%44%', date("d/m/Y", $date_4), str_replace('%33%', date("d/m/Y", $date_3), str_replace('%22%', date("d/m/Y", $date_2), str_replace('%11%', date("d/m/Y", $date_1), str_replace('%4%', date("Y-m-d", $date_4), str_replace('%3%', date("Y-m-d", $date_3), str_replace('%2%', date("Y-m-d", $date_2), str_replace('%1%', date("Y-m-d", $date_1), str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true))))))))))));
};
mysqli_close();
?>