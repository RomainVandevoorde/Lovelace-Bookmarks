<?php

require_once __DIR__."/includes/global.php";
require_once __DIR__."/db.php";

// Get all categories
$rep_cats = $bdd->query('SELECT * FROM `categories`');
$data_cats = $rep_cats->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('about.html', array('categories'=>$data_cats));



?>
