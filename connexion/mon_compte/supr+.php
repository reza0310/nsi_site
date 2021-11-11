<?php
$host = 'db5001658372.hosting-data.io';
$user = 'dbu1687571';
$pw = 'U741abc**';
$db = 'dbs1375270';
$link = mysqli_connect($host, $user, $pw, $db) or die ('Nous ne pouvons pas suprimer votre commande, pour des problèmes de connections '.mysqli_connect_error());
mysqli_set_charset ($link,"utf8");

echo "<a href='https://novsite.jeannedarc-bretigny.fr' >le lien fonctionne</a>";

?>