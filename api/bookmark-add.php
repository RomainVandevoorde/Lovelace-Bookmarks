<?php

header('Content-Type: application/json');

require_once __DIR__.'/../includes/validate-fct.php';

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
$category = isset($_POST['category']) ? intval($_POST['category']) : 1;

$v_cat = validateCategory($category);
if($v_cat !== TRUE) $errors[] = $v_cat;
elseif($category !== 1) {
  require_once __DIR__.'/../db.php';
  $req_cat = $bdd->prepare("SELECT * FROM categories WHERE id = ?");
  $req_cat->execute(array($category));
  $data_cat = $req_cat->fetch();
  if(!$data_cat) $errors[] = "This category doesn't exist";
}


// Validate Title
$v_title = validateTitle($_POST['title']);
if($v_title !== TRUE) $errors[] = $v_title;

// Validate URL
$url = validateUrl($_POST['url']);
if($url === FALSE) $errors[]= 'Invalid URL';

// Validate description
$description = isset($_POST['description']) ? $_POST['description'] : "";
$v_desc = validateDescription($description);
if($v_desc !== TRUE) $errors[] = $v_desc;

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
