<?php

// JSON exit
function exitJson($success, $errors = 'Unexpected Error') {
  if($success) exit(json_encode(array('success' => TRUE)));
  else {
    if(gettype($errors) !== 'array') $errors = array($errors);
    exit(json_encode(array('success' => FALSE, 'errors' => $errors)));
  }
}

function validateUrl($url) {
  if(gettype($url) !== "string") return FALSE;
  if(empty($url)) return FALSE;

  $parse = parse_url($url);

  // Check the URL's protocol
  if(!isset($parse['scheme'])) $url = 'http://'.$url;
  elseif($parse['scheme'] !== 'http' && $parse['scheme'] !== 'https') return FALSE;

  if(filter_var($url, FILTER_VALIDATE_URL) === false) return FALSE;

  return $url;
}

function validateTitle($title) {
  if(empty($title)) return "Got an empty title";
  if(gettype($title) !== "string") return "Invalid title type";
  $length = strlen($title);
  if($length < 2) return "Title is too short (< 2)";
  if($length > 100) return "Title is too long (> 100)";
  return TRUE;
}

function validateCategory($cat) {
  if(empty($cat)) return "Got an empty category";
  if(gettype($cat) !== "integer") return "Invalid category type";
  if($cat < 1) return "Invalid category (< 1)";
  return TRUE;
}

function validateDescription($desc) {
  if(gettype($desc) !== "string") return "Invalid description type";
  if(empty($desc)) return TRUE;
  $length = strlen($desc);
  if($length > 150) return "Description is too long (> 150)";
  return TRUE;
}


?>
