<?php
set_include_path(dirname(__DIR__, 2).'\\vars');
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db) or die ("Erreur");

$mail = $_POST["mail"];
$mdp = $_POST["mdp"];
$date = $_POST["date"];
$heure = $_POST["heure"];

$connexion = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM clients WHERE c_mail = '$mail' AND c_pw = '$mdp'"));
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
if (($date == $date_1 or $date == $date_2 or $date == $date_3 or $date == $date_4) and ((intval(substr($heure, 0, 2)) >= 16 and intval(substr($heure, 2, 2)) >= 30) and (intval(substr($heure, 0, 2)) <= 18 and intval(substr($heure, 2, 2)) <= 30))) {
	
	$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3'");  // On parcours tout les articles pour copier la commande hidden par hidden
	$hidden = "<input type='hidden' value='".$mail."' name='mail'><input type='hidden' value='".$mdp."' name='mdp'>";  // STR à injecter dans le HTML pour le stockage de la commande
	while ($produit=mysqli_fetch_array($check)) {
		$hidden .= "<input type='hidden' value='".strval($_POST['n'.strval($produit[0])])."' name='n".$produit[0]."'>";
	};
	
	echo(str_replace('%hidden%', $hidden, str_replace('%corps%', file_get_contents('.//horaires//page.html'), file_get_contents('head.html', true))));
	mysqli_close();
} else {
	$datee = $date." ".$heure;
	$id = $connexion[0];
	$numero = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM commandes WHERE co_cli = $id"))[0]+1;
	$comm_id = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM commandes"))[0]+1;
	
	mysqli_query($link ,"INSERT INTO commandes (co_id, co_date, co_numero, co_cli, co_etat, co_date_rdv) VALUES ('$comm_id', DATE(NOW()), '$numero', '$id', '1', '$datee')");  // Création de la commande
	$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '0'");  // On parcours tout les articles pour copier la commande hidden par hidden
	$surplus = 0;
	while ($produit=mysqli_fetch_array($check)) {
		$index = $produit[0];  // Index de produit
		$qtte = $_POST['n'.strval($index)];
		if ($qtte != 0) {
			$article = mysqli_fetch_array(mysqli_query($link ,"SELECT a_pv, a_pr FROM articles WHERE a_id = $index"));
			$qtte_article =  mysqli_fetch_array(mysqli_query($link ,"SELECT a_qtte_stock FROM articles WHERE a_id = $index"))[0] - $qtte;
			if ($qtte_article < 0) {
				$surplus += 1;
			} else {
				mysqli_query($link ,"UPDATE articles SET a_qtte_stock = $qtte_article WHERE a_id = $index");  // Diminution de la quantité
				mysqli_query($link ,"INSERT INTO details (d_articles, d_qtte, d_com, d_pv, d_pr) VALUES ($index, $qtte, $comm_id, $article[0], $article[1])");  // Remplissage de la commande
			};
		};
	};
	if ($surplus != 0) {
		$datee .= " ($surplus articles en surplus n'ont pas été ajoutés à votre commande)";
	};
	echo(str_replace('%date%', $datee, str_replace('%hidden%', "<input type='hidden' value='$mail' name='mail'><input type='hidden' value='$mdp' name='mdp'>", str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true)))));
};
mysqli_close();
?>