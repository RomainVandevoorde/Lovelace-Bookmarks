<?php

require "includes/global.php";
require "db.php";

$template = $twig->load('category.html');

if(!isset($_GET['id']) || $_GET['id'] < 0) {
  echo $template->render(array('bookmarks'=>array(array('titre'=>'nope'))));
}

else {

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE category_id = ?");
  $req->execute(array($_GET['id']));
  $data = $req->fetchAll(PDO::FETCH_ASSOC);

  echo $template->render(array('bookmarks' => $data));


}




?>
