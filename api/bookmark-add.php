<?php

function validateUrl($url) {

  $parse = parse_url($url);

  if(!isset($parse['scheme'])) $url = 'https://'.$url;
  elseif($parse['scheme'] !== 'http' && $parse['scheme'] !== 'https') $url = 'https://'.$parse['path'];

  if(filter_var($url, FILTER_VALIDATE_URL) === false) return false;

  // var_dump(parse_url($url));
  // echo '<br>PHP_URL_SCHEME : '.parse_url($url, PHP_URL_SCHEME).'<br>';
  // echo 'PHP_URL_USER : '.parse_url($url, PHP_URL_USER).'<br>';
  // echo 'PHP_URL_PASS : '.parse_url($url, PHP_URL_PASS).'<br>';
  // echo 'PHP_URL_HOST : '.parse_url($url, PHP_URL_HOST).'<br>';
  // echo 'PHP_URL_PORT : '.parse_url($url, PHP_URL_PORT).'<br>';
  // echo 'PHP_URL_PATH : '.parse_url($url, PHP_URL_PATH).'<br>';
  // echo 'PHP_URL_QUERY : '.parse_url($url, PHP_URL_QUERY).'<br>';
  // echo 'PHP_URL_FRAGMENT : '.parse_url($url, PHP_URL_FRAGMENT).'<br>';
  return true;

}

$errors = array();

// If there's no title or no url provided, exit script
if(!isset($_POST['title']) || !isset($_POST['url'])) {
  $errors []= 'Insufficient data';
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


if(!empty($errors)) {
  echo json_encode(array('success' => false, 'errors' => $errors));
}
else echo json_encode(array('success' => true));


require '../db.php';

// TODO connect to databse

// TODO get POST data & validate it

// TODO add the bookmark if the POST data is valid

?>
