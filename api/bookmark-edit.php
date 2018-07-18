<?php

session_start();

// Check if there's data
if(count($_POST) < 1) exit('invalid request');
if(!isset($_POST['title']) && !isset($_POST['url']) && !isset($_POST['category']) && !isset($_POST['description'])) {
  exit('invalid request');
}

// Basic checks
if(!isset($_SESSION['user_id'])) exit('You must be connected');
if(!isset($_POST['id'])) exit('No bookmark specified');
$id = (int) $_POST['id'];
if($id < 1) exit('Invalid ID');

// Check DB
require_once __DIR__.'/../db.php';

$req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
$req->execute(array($id));
$data = $req->fetch();
if(!$data) exit("This bookmark doesn't exist");

// Check user rights
if($_SESSION['rights'] < 2 && intval($data['user_added']) !== $_SESSION['user_id']) exit("You don't have the rights to edit this bookmark");


$up_title = isset($_POST['title']) ? $_POST['title'] : $data['titre'];
$up_url = isset($_POST['url']) ? $_POST['url'] : $data['url'];
$up_cat = isset($_POST['category']) ? $_POST['category'] : $data['category_id'];
$up_descr = isset($_POST['description']) ? $_POST['description'] : $data['description'];

if(strlen($up_title) < 2 || strlen($up_title) > 100) exit('title is too long');
if(strlen($up_url) < 2 || strlen($up_url) > 100) exit('URL prout');
if(intval($up_cat) < 1 || intval($up_cat) > 10) exit('Category prout');
if(strlen($up_descr) > 200) exit('too long description');

$req = $bdd->prepare("UPDATE bookmarks SET titre = ?, url = ?, category_id = ?, description = ? WHERE id = ?");
if($req->execute(array($up_title, $up_url, $up_cat, $up_descr, $data['id']))) {
  exit('<p>success !</p> <p><a href="../bookmark.php?id='.$id.'">See bookmark</a></p>');
}
else {
  exit('failed');
}

?>
