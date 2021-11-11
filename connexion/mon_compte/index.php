 <?php
set_include_path(dirname(__DIR__, 2).'\\vars');
include('db.php');
$link = mysqli_connect($host, $user, $pw, $db) or die ("Erreur");

$mail=$_POST['mail'];
$mdp=$_POST['mdp'];

$connexion = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM clients WHERE c_mail = '$mail' AND c_pw = '$mdp'"));
if (count($connexion) < 10) {
	echo (str_replace('/commande/', '/mon_compte/', str_replace('%hidden%', "", str_replace('%corps%', file_get_contents(dirname(__DIR__, 1).'\\page.html'), file_get_contents('head.html', true)))));
} else {
	$total = 0;
	$inject = "";
	$id_client = $connexion[0];
	$commandes = mysqli_query($link ,"SELECT * FROM commandes WHERE co_cli = $id_client");
	while ($comm=mysqli_fetch_array($commandes)) {
		$sous_total = 0;
		$inject .= "<div class='article' style='height: auto;'>Commande passée le $comm[1] pour le $comm[5]:<br>";
		$produits = mysqli_query($link ,"SELECT * FROM details WHERE d_com = $comm[0]");
		while ($prod=mysqli_fetch_array($produits)) {
			$article = mysqli_fetch_array(mysqli_query($link ,"SELECT * FROM articles WHERE a_id = $prod[1]"));
			$inject .= "-$prod[2] $article[1] à $prod[4] €<br>";
			$sous_total += $prod[2] * $prod[4];
		}
		$total += $sous_total;
		$inject .= "TOTAL: $sous_total €<br></div>";
	}
	echo(str_replace('%corps%', $inject."TOTAL: $total €", file_get_contents('head.html', true)));
};
mysqli_close();
echo '<a href="https://novsite.jeannedarc-bretigny.fr/" > <h3>retour</h3> </a>';
echo '<a href="https://novsite.jeannedarc-bretigny.fr/connexion/mon_compte/supr_service.html" > <h3>retour</h3> </a>';
?>