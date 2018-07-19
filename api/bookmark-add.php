<?php

header('Content-Type: application/json');

function exitJson($success, $errors = 'Unexpected Error') {
  if($success) exit(json_encode(array('success' => TRUE)));
  else {
    if(gettype($errors) !== 'array') $errors = array($errors);
    exit(json_encode(array('success' => FALSE, 'errors' => $errors)));
  }
}

function validateUrl($url) {
  $parse = parse_url($url);

  // Check the URL's protocol
  if(!isset($parse['scheme'])) $url = 'https://'.$url;
  elseif($parse['scheme'] !== 'http' && $parse['scheme'] !== 'https') return FALSE;

  if(filter_var($url, FILTER_VALIDATE_URL) === false) return FALSE;

  return $url;
}

// *******************
//
// START SCRIPT
//
// *******************


session_start();

require_once __DIR__.'/../includes/auth-fct.php';

if(!hasRights(1)) exitJson(FALSE, 'Insufficient Rights');

$errors = array();

// If there's no title or no url provided, exit script
if(!isset($_POST['title']) || !isset($_POST['url'])) {
  exitJson(FALSE, 'Insufficient data');
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
$url = validateUrl($_POST['url']);
if($url === FALSE) $errors[]= 'Invalid URL';

// Validate description
if(isset($_POST['description'])) {
  $desc_length = strlen($_POST['description']);
  if($desc_length > 300) $errors []= 'This description is too long';
}
// If no description was posted, put in an empty string
$description = isset($_POST['description']) ? $_POST['description'] : "";

// Exit if there are errors
if(!empty($errors)) {
  exitJson(FALSE, $errors);
}


require_once __DIR__.'/../db.php';

// Proceed with insertion
$req = $bdd->prepare("INSERT INTO bookmarks (titre, url, description, user_added, category_id) VALUES (?, ?, ?, ?, ?)");
if($req->execute(array($_POST['title'], $url, $description, $_SESSION['user_id'], 1))) {
  exitJson(TRUE);
}
else {
  exitJson(FALSE, 'Insertion failure');
}

?>
