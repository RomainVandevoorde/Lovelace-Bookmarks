<?php

session_start();

require_once __DIR__.'/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    // 'cache' => 'compilation_cache',
    // 'debug' => true
));

require_once __DIR__.'/../db.php';

$req = $bdd->query("SELECT * FROM categories");
$data_categories = $req->fetchAll(PDO::FETCH_ASSOC);
$req->closeCursor();

$twig->addGlobal('categories', $data_categories);

// Connects the user if his github id is stored but not his user_id or rights
// Happens when the user connected through Github for the first time
if(isset($_SESSION['github_id']) && (!isset($_SESSION['user_id']) || !isset($_SESSION['rights']))) {
  $req = $bdd->prepare("SELECT * FROM users WHERE github_id = ?");
  $req->execute(array($_SESSION['github_id']));
  $data = $req->fetch();
  $req->closeCursor();

  if($data === FALSE) exit('DB request failed');
  else {
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['rights'] = $data['rights'];
    unset($_SESSION['github_id']);
    echo '<p>You are now connected</p>';
  }
}

if(isset($_SESSION['user_id']) && isset($_SESSION['rights'])) {
  if(intval($_SESSION['user_id']) < 1) exit('invalid user');
  $twig->addGlobal('user', array('id'=>$_SESSION['user_id'], 'rights'=>$_SESSION['rights']));
}

$twig->addGlobal('GET', $_GET);

require_once __DIR__.'/auth-fct.php';
