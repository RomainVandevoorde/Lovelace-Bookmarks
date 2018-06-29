<?php

session_start();

if(isset($_SESSION['user_id'])) exit('Already connected');

require 'vendor/autoload.php';
require 'includes/hybridauth-config.php';

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

echo '<p>Github Auth: Success</p>';

require 'db.php';

$req_exists = $bdd->prepare("SELECT * FROM users WHERE github_id = ?");
$req_exists->execute(array($userProfile->identifier));
$data_exists = $req_exists->fetch();

// echo '<br><br><br>DB DATA<br><br>';
// var_dump($data_exists);
// echo '<br><br>';

if($data_exists === FALSE) {
  // User does not yet exist, create the account
  $req_newuser = $bdd->prepare("INSERT INTO users (github_displayName, github_id, rights) VALUES (?, ?, 0)");
  $res = $req_newuser->execute(array($userProfile->displayName, $userProfile->identifier));
  if($res) {
    echo '<p>Your account was successfully created !</p>';
    $_SESSION['github_id'] = $userProfile->identifier;
  }
  else echo '<p>Failed to create your account</p>';
}
else {
  if($data_exists['github_displayName'] === $userProfile->displayName) {
    $_SESSION['user_id'] = $data_exists['id'];
    $_SESSION['rights'] = $data_exists['rights'];
    echo '<p>Welcome back '.$userProfile->displayName.' !</p>';
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
