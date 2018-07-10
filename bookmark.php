<?php

require __DIR__.'/includes/global.php';

if(isset($_GET['action'])) {

  switch ($_GET['action']) {
    case 'add':
      echo $twig->render('form-bookmark-add.html');
      break;
    case 'edit':
      // TODO edit form
      break;
    default:
      echo 'Invalid action';
      break;
  }

}

// If no action but there's an ID, display bookmark
elseif(isset($_GET['id'])) {

  require_once 'db.php';

  $bookmark_id = (int) $_GET['id'];

  if($bookmark_id < 0) exit('invalid id');

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
  $req->execute(array($bookmark_id));
  $data = $req->fetch(PDO::FETCH_ASSOC);

  echo $twig->render('bookmark-display.html', $data);

}

else {
  exit ('Invalid action');
}

?>
