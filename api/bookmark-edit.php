<?php

// header('Content-Type: application/json');

session_start();

require_once __DIR__.'/../includes/validate-fct.php';

// Check if there's data
if(count($_POST) < 1) exitJson(FALSE, 'invalid request');
if(!isset($_POST['title']) && !isset($_POST['url']) && !isset($_POST['category']) && !isset($_POST['description'])) {
  exitJson(FALSE, 'invalid request');
}

// Basic checks
if(!isset($_SESSION['user_id'])) exitJson(FALSE, 'You must be connected');
if(!isset($_POST['id'])) exitJson(FALSE, 'No bookmark specified');
$id = (int) $_POST['id'];
if($id < 1) exitJson(FALSE, 'Invalid ID');

// Check DB
require_once __DIR__.'/../db.php';

$req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
$req->execute(array($id));
$data = $req->fetch();
if(!$data) exitJson(FALSE, "This bookmark doesn't exist");

// Check user rights
if($_SESSION['rights'] < 2 && intval($data['user_added']) !== $_SESSION['user_id']) exitJson(FALSE, "You don't have the rights to edit this bookmark");


$up_title = isset($_POST['title']) ? $_POST['title'] : $data['titre'];
$up_url = isset($_POST['url']) ? $_POST['url'] : $data['url'];
$up_cat = isset($_POST['category']) ? $_POST['category'] : $data['category_id'];
$up_descr = isset($_POST['description']) ? $_POST['description'] : $data['description'];

// if(strlen($up_title) < 2 || strlen($up_title) > 100) exit('title is too long');
// if(strlen($up_url) < 2 || strlen($up_url) > 100) exit('URL prout');
// if(intval($up_cat) < 1 || intval($up_cat) > 10) exit('Category prout');
// if(strlen($up_descr) > 200) exit('too long description');

$v_title = validateTitle($up_title);
if($v_title !== TRUE) exitJson(FALSE, $v_title);

// Validate URL
$url = validateUrl($up_url);
if($url === FALSE) exitJson(FALSE, 'Invalid URL');

// Validate Category
$category = (int) $up_cat;
$v_cat = validateCategory($category);
if($v_cat !== TRUE) exitJson(FALSE, $v_cat);
else {
  $req_cat = $bdd->prepare("SELECT * FROM categories WHERE id = ?");
  $req_cat->execute(array($category));
  $data_cat = $req_cat->fetch();
  if(!$data_cat) exitJson(FALSE, "This category doesn't exist");
}

$req = $bdd->prepare("UPDATE bookmarks SET titre = ?, url = ?, category_id = ?, description = ? WHERE id = ?");
if($req->execute(array($up_title, $up_url, $up_cat, $up_descr, $data['id']))) {
  exitJson(TRUE);
}
else {
  exitJson(FALSE, 'failed');
}

?>
