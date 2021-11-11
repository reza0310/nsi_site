<?php
set_include_path('.\\vars');
include('db.php');  // On importe les variables de connection
$link = mysqli_connect($host, $user, $pw, $db) or die ('Erreur '.mysqli_connect_error());  // Puis on se connecte
mysqli_set_charset ($link,"utf8");  // On rempli les modalités

$res = "";  // STR à injecter dans le HTML pour l'apparence
$hidden = "";  // STR à injecter dans le HTML pour le stockage
$familles = mysqli_query($link ,"SELECT a_famille FROM articles WHERE a_etat != '3' GROUP BY a_famille");  // On veux trier les articles par famille donc on commence par lister ces dernières.
$index_f = 0;  // Index de famille
$cpt = 0;
while ($famille=mysqli_fetch_array($familles)) {  // On parcourt les familles
	$index_f += 1;
	$res .= "<div class='article_parent' id='f".$index_f."'><img src='.\\images\\".($index_f).".png' alt='$famille[0]' height=100 style='display: inherit;'></img><r class='titre-article' style='display: inherit;'>".$famille[0]."</r>";  // Article conteneur
	$check = mysqli_query($link ,"SELECT * FROM articles WHERE a_etat != '3' AND a_famille='$famille[0]'");  // On extrait tout les articles d'un famille
	while ($produit=mysqli_fetch_array($check)) {
		$index_p = $produit[0];  // Index de produit
		if ($index_p > $cpt) {
			$cpt = $index_p;
		};
		$inject = "";
		if ($produit[3] == 0) {
			$inject = "<div class='plusdestock'>Plus de stock!</div>";
		};
		$res .= "<div class='article' id='p$index_p' style='display: none;'><img src='.\\images\\$index_p.jpg' alt='$produit[1]' height=100></img>".$inject."<r class='description-article' id='d$index_p'>".$produit[2]."<br></r><r class='titre-article'>".$produit[1]."</r><p id='prix'>".$produit[4]."€</p><p id='quantite'>Reste:<br>".$produit[3]."</p></div>";  // Article contenu
		$hidden .= "<input type='hidden' value='0' name='n".$index_p."' max='$produit[3]'>";
	};
	$res .= "</div><button class='article' id='close_$index_f' style='display: none;'><p>Fermer</p></button>";  // Article conteneur
};
$hidden .= "<input type='hidden' value='$cpt' name='nbre'>";
$hidden .= "<input type='hidden' value='$index_f' name='fam'>";
echo (str_replace("%hidden%", $hidden, str_replace('<div style="display: none;"></div>', '<form class="div2" action="https://novsite.jeannedarc-bretigny.fr/connexion/index.php" method="post">%hidden%<input class="bouton" type="submit" value="Commander" id="commander"></form>', str_replace('%php%', $res, str_replace('%corps%', file_get_contents('page.html'), file_get_contents('head.html', true))))));
mysqli_close($link);
?>