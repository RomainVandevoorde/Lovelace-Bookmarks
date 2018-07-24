<?php

session_start();

if(isset($_SESSION['user_id'])) exit('<p>Already connected</p><p><a href="./">Back to home</a></p>');
if(isset($_SESSION['github_id'])) exit('<p>Awaiting validation</p><p><a href="./">Back to home</a></p>');

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/includes/hybridauth-config.php';

$github = new Hybridauth\Provider\GitHub($config);

try {
  $github->authenticate();
} catch(Exception $e) {
  exit('<p>Authentication failed</p><p>'.$e->getMessage().'</p>');
}

try {
  $userProfile = $github->getUserProfile();
} catch(Exception $e) {
  exit('<p>Failed to fetch profile</p><p>'.$e->getMessage().'</p>');
}

require_once __DIR__.'/db.php';

$req_exists = $bdd->prepare("SELECT * FROM users WHERE github_id = ?");
$req_exists->execute(array($userProfile->identifier));
$data_exists = $req_exists->fetch();


if($data_exists === FALSE) {
  // User does not yet exist, create the account
  $req_newuser = $bdd->prepare("INSERT INTO users (github_displayName, github_id, rights) VALUES (?, ?, 0)");
  $res = $req_newuser->execute(array($userProfile->displayName, $userProfile->identifier));
  // On success, connect user and redirect to profile
  if($res) {
    $_SESSION['user_id'] = $bdd->lastInsertId();
    $_SESSION['rights'] = 0;
    $_SESSION['notifications'][] = array(
      'class' => 'is-success',
      'messages' => array('Your account was successfully created !')
    );
    header('Location: profile.php');
  }
  // On failure, redirect to index
  else {
    $_SESSION['notifications'][] = array(
      'class' => 'is-danger',
      'messages' => array('Failed to create your account :(')
    );
    header('Location: index.php');
  }
}
else {
  $_SESSION['user_id'] = $data_exists['id'];
  $_SESSION['rights'] = $data_exists['rights'];
  if($data_exists['github_displayName'] === $userProfile->displayName) {
    $_SESSION['welcome'] = TRUE;
    $_SESSION['notifications'][] = array(
      'class' => 'is-success',
      'messages' => array('Successfully logged in ! :)')
    );
    header('Location: profile.php');
  }
  else {
    echo '<br>displayName in the database is different then the one received from Github. WTF ?';
  }
}

// $_SESSION['github_login'] = $userProfile->login;
// identifier (id)
// profileURL
// photoURL
// displayName

$github->disconnect();


?>
