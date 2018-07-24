<?php

require_once __DIR__."/includes/global.php";
require_once __DIR__."/db.php";

if(!isset($_GET['id']) || $_GET['id'] < 1) {

  header('Location: index.php');

  // $req_cat = $bdd->query("SELECT * FROM categories");
  // $data_cat = $req_cat->fetchAll(PDO::FETCH_ASSOC);
  //
  // if(!$data_cat) echo $twig->render('bookmarks.html', array('errors'=>array('Failed to fetch categories')));
  // else echo $twig->render('categories.html', array('categories'=>$data_cat, 'errors'=>array('prout')));

}

else {

  // Get all categories
  $rep_cats = $bdd->query('SELECT * FROM `categories`');
  $data_cats = $rep_cats->fetchAll(PDO::FETCH_ASSOC);

  // Check category existence
  $cat = (int) $_GET['id'];

  $req_cat = $bdd->prepare("SELECT name FROM categories WHERE id = ?");
  $req_cat->execute(array($cat));
  $data_cat = $req_cat->fetch(PDO::FETCH_ASSOC);

  if(!$data_cat) exit($twig->render('main.html', array('errors'=>array('unknown category'))));

  // Get bookmark
  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE category_id = ?");
  $req->execute(array(intval($cat)));
  $data = $req->fetchAll(PDO::FETCH_ASSOC);

  if($data) echo $twig->render('bookmarks-list.html', array('bookmarks'=>$data, 'category'=>$data_cat, 'categories'=>$data_cats));
  else echo $twig->render('main.html', array('errors' => array("No bookmarks found"), 'categories'=>$data_cats));

}


?>
