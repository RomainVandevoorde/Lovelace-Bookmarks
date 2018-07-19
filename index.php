<?php

require_once __DIR__.'/includes/global.php';
require_once __DIR__.'/db.php';

$rep = $bdd->query('SELECT * FROM `bookmarks` LIMIT 0, 10');
$data = $rep->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('index.html', array('data' => $data));
// $req = $bdd->prepare('SELECT titre FROM `bookmarks` WHERE titre = ?');
// $req->execute(($_GET['titre']));

// echo '<p>Voici les 10 premières entrées de Bookmarks  :</p>'; // + categrorie ??
// while ($data = $rep->fetch())
//   {
//     echo $data['titre'] . '<br />';
//   }

//$req->closeCursor();
/*
  1- require sur chaque fichier ?
2- access by localhost only for the index.php file, ...why ?
3- niveau securité des qurey sql: utiliser un require sur toute les pages ou ajouter le morceau de code sur chaque page ?
4- Dans le NEW DB l'utiliser ou trouver une methode plus simple si possible ?
5- pour les categories: preparer des id/name par categorie genre html css js ...., ou laisser des nmbre/"" à modifier après ?,

*/
?>
