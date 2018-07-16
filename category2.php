<?php

require_once __DIR__."/includes/global.php";
require_once __DIR__."/db.php";

if(!isset($_GET['id']) || $_GET['id'] < 1) {

  $req = $bdd->query("SELECT * FROM categories");
  $data = $req->fetchAll(PDO::FETCH_ASSOC);

  if(!$data) echo $twig->render('bookmarks.html', array('errors'=>array('Failed to fetch categories')));
  else echo $twig->render('categories.html', array('categories'=>$data));

}

else {

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE category_id = ?");
  $req->execute(array(intval($_GET['id'])));
  $data = $req->fetchAll(PDO::FETCH_ASSOC);

  echo $twig->render('bookmarks.html', array('bookmarks' => $data));

}


?>
