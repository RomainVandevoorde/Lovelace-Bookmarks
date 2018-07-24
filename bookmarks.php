<?php

require_once __DIR__.'/includes/global.php';
require_once __DIR__.'/db.php';

$rep = $bdd->query('SELECT * FROM `bookmarks`');
$data = $rep->fetchAll();

echo $twig->render('bookmarks.html', array('bookmarks'=>$data));

$rep->closeCursor();
?>
