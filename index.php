<?php

require_once __DIR__.'/includes/global.php';
require_once __DIR__.'/db.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Index</title>
</head>
<body>

  <h1>MVP: List the categories</h1>
  <h2>Secondary objectives:</h2>
  <p>
    <ul>
      <li>List latest bookmarks added</li>
    </ul>
  </p>
  <?php
  
    $rep = $bdd->query('SELECT * FROM `bookmarks` LIMIT 0, 10');
    // $req = $bdd->prepare('SELECT titre FROM `bookmarks` WHERE titre = ?');
    // $req->execute(($_GET['titre']));

    echo '<p>Voici les 10 premières entrées de Bookmarks  :</p>'; // + categrorie ??
    while ($data = $rep->fetch())
      {
        echo $data['titre'] . '<br />';
      }

    //$req->closeCursor();
    /*
      1- require sur chaque fichier ?
    2- access by localhost only for the index.php file, ...why ?
    3- niveau securité des qurey sql: utiliser un require sur toute les pages ou ajouter le morceau de code sur chaque page ?
    4- Dans le NEW DB l'utiliser ou trouver une methode plus simple si possible ?
    5- pour les categories: preparer des id/name par categorie genre html css js ...., ou laisser des nmbre/"" à modifier après ?,

   */
  ?>


</body>
</html>
