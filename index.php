<?php

require_once __DIR__.'/includes/global.php';
require_once __DIR__.'/db.php';

$rep_cat = $bdd->query('SELECT * FROM `categories`');
$data_cat = $rep_cat->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('main.html', array('categories' => $data_cat));
?>
