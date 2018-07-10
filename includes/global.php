<?php

session_start();

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    // 'cache' => 'compilation_cache',
    // 'debug' => true
));

// Connects the user if his github id is stored but not his user_id or rights
// Happens when the user connected through Github for the first time
if(isset($_SESSION['github_id']) && (!isset($_SESSION['user_id']) || !isset($_SESSION['rights']))) {

  require_once 'db.php';
  $req = $bdd->prepare("SELECT * FROM users WHERE github_id = ?");
  $req->execute(array($_SESSION['github_id']));
  $data = $req->fetch();

  if($data === FALSE) exit('DB request failed');
  else {
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['rights'] = $data['rights'];
    unset($_SESSION['github_id']);
    echo 'connected';
  }

}

require __DIR__.'/auth-fct.php';
