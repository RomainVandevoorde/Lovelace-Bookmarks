<?php

session_start();

require_once __DIR__.'/../includes/auth-fct.php';

if(!hasRights(1)) exit('Insufficient Rights');

function validateUrl($url) {

  $parse = parse_url($url);

  if(!isset($parse['scheme'])) $url = 'https://'.$url;
  elseif($parse['scheme'] !== 'http' && $parse['scheme'] !== 'https') $url = 'https://'.$parse['path'];

  if(filter_var($url, FILTER_VALIDATE_URL) === false) return false;

  return true;
}

$errors = array();

// If there's no title or no url provided, exit script
if(!isset($_POST['title']) || !isset($_POST['url'])) {
  $errors []= 'Insufficient data';
  exit(json_encode(array('success' => false, 'errors' => $errors)));
}

// If there's no category, use 1 as default
if(!isset($_POST['category'])) {
  $category = 1;
}


// Validate Title
$title_length = strlen($_POST['title']);
if($title_length < 2 || $title_length > 100) {
  $errors []= 'This title is too short or too long (must be 2-100 characters)';
}

// Validate URL
if(!validateUrl($_POST['url'])) $errors[]= 'Invalid URL';

// Validate description
if(isset($_POST['description'])) {
  $desc_length = strlen($_POST['description']);
  if($desc_length > 300) $errors []= 'This description is too long';
}
// If no description was posted, put in an empty string
$description = isset($_POST['description']) ? $_POST['description'] : "";


if(!empty($errors)) {
  exit(json_encode(array('success' => false, 'errors' => $errors)));
}
else echo json_encode(array('success' => true));


require '../db.php';

$req = $bdd->prepare("INSERT INTO bookmarks (titre, url, description, user_added, category_id) VALUES (?, ?, ?, ?, ?)");
$req->execute(array($_POST['title'], $_POST['url'], $description, 1, 1));

?>
