<?php

require_once __DIR__."/includes/global.php";

if(!isset($_SESSION['user_id'])) JSredirect("index.php");

$uid = (int) $_SESSION['user_id'];

if($uid < 1) header('Location: '.__DIR__.'/logout.php');

$req = $bdd->prepare("SELECT * FROM users WHERE id = ?");
$req->execute(array($uid));
$data_user = $req->fetch();

if(!$data_user) exit($twig->render('profile.html', array('errors'=>array('failed to fetch user'))));

$render_data = array('user'=>array('name'=>$data_user['github_displayName']));

$req = $bdd->prepare("SELECT * FROM bookmarks WHERE user_added = ?");
$req->execute(array($uid));
$data_bookmarks = $req->fetchAll();

$render_data['bookmarks'] = $data_bookmarks;

if(isset($_SESSION['welcome'])) {
  $render_data['welcome'] = TRUE;
  unset($_SESSION['welcome']);
}

echo $twig->render('profile.html', $render_data);

?>
