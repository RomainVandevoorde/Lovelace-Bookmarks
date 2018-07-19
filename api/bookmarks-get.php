<?php

header('Content-Type: application/json');

require_once __DIR__."/../db.php";

if(isset($_GET['cat'])) {
  $cat = (int) $_GET['cat'];
  getByCategory($cat);
}
elseif(isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  getOne($id);
}
else {
  getAll();
}


function getAll() {
  global $bdd;

  $req = $bdd->query("SELECT * FROM bookmarks");

  if($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
    exit(json_encode(array('success' => true, 'data' => $data)));
  }
  else {
    exit(json_encode(array('success' => false, 'errors' => array('no result'))));
  }

}

function getOne($id) {
  global $bdd;

  if($id < 1) exit(json_encode(array('success' => false, 'errors' => array('Invalid ID'))));

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
  $req->execute(array($id));

  if($data = $req->fetch(PDO::FETCH_ASSOC)) {
    exit(json_encode(array('success' => true, 'data' => $data)));
  }
  else {
    exit(json_encode(array('success' => false, 'errors' => array('no result'))));
  }

}

function getByCategory($cat) {
  global $bdd;

  // Exit JSON if invalid ID
  if($cat < 1) exit(json_encode(array('success' => false, 'errors' => array('Invalid category ID'))));

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE category_id = ?");
  $req->execute(array($cat));

  if($data = $req->fetchAll(PDO::FETCH_ASSOC)) {
    exit(json_encode(array('success' => true, 'data' => $data)));
  }
  else {
    exit(json_encode(array('success' => false, 'errors' => array('no result'))));
  }

}


?>
