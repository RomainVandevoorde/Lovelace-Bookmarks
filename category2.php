<?php

require_once __DIR__."/includes/global.php";
require_once __DIR__."/db.php";

if(!isset($_GET['id']) || $_GET['id'] < 0) {

  $req = $bdd->query("SELECT * FROM categories");
  $data = $req->fetchAll(PDO::FETCH_ASSOC);
  var_dump($data);
  if(!$data) $twig->render('bookmarks.html', array('errors'=>array('Failed to fetch categories')));
  else $twig->render('categories.html', $data);

  exit;

  // echo $template->render(array('bookmarks'=>array(array('titre'=>'nope'))));

}

else {

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE category_id = ?");
  $req->execute(array($_GET['id']));
  $data = $req->fetchAll(PDO::FETCH_ASSOC);

  echo $template->render('bookmarks.html', array('bookmarks' => $data));


}




?>
