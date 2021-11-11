<?php
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

set_include_path(dirname(__DIR__, 2).'\\vars');
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db) or die ("Erreur");

$mail=$_POST['mail'];
$mdp=$_POST['mdp'];

$connexion = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM clients WHERE c_mail = '$mail' AND c_pw = '$mdp'"));
$id_client = $connexion[0];
$commandes = mysqli_query($link ,"SELECT * FROM commandes WHERE co_cli = $id_client ORDER BY co_id DESC LIMIT 1");
$ligne = 10;
$pdf->Image('logo.png',10,10,-300);
while ($comm=mysqli_fetch_array($commandes)) {
	$sous_total = 0;
	$pdf->Text(10,$ligne,utf8_decode("Commande passée le $comm[1] pour le $comm[5]:"));
	$ligne += 10;
	$produits = mysqli_query($link ,"SELECT * FROM details WHERE d_com = $comm[0]");
	while ($prod=mysqli_fetch_array($produits)) {
		$article = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM articles WHERE a_id = $prod[1]"));
		$pdf->Text(10,$ligne,utf8_decode("-$prod[2] $article[1] à $article[4] euros"));
		$ligne += 10;
		$sous_total += $prod[2] * $article[4];
	};
	$pdf->Text(10,$ligne,utf8_decode("Total: $sous_total euros."));
	$ligne += 20;
};
mysqli_close();
$pdf->Output("D");
?>