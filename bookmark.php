<?php

require __DIR__.'/includes/global.php';

if(isset($_GET['action'])) {

  switch ($_GET['action']) {
    case 'add':
      if(!hasRights(1)) echo $twig->render('bookmarks-list.html', array('errors'=>array("You don't have sufficient rights to add a bookmark")));
      else echo $twig->render('forms/bookmark-add.html');
      exit;
      break;
    // ******************
    //
    // EDIT
    //
    // ******************
    case 'edit':
      // Basic checks
      if(!isset($_SESSION['user_id'])) exit('You must be connected');
      if(!isset($_GET['id'])) exit('No bookmark specified');
      $id = (int) $_GET['id'];
      if($id < 1) exit('Invalid ID');

      // Check DB
      require_once __DIR__.'/db.php';
      $req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
      $req->execute(array($id));
      $data = $req->fetch();
      if(!$data) exit("This bookmark doesn't exist");

      // Check user rights
      if($_SESSION['rights'] < 2 && intval($data['user_added']) !== $_SESSION['user_id']) exit("You don't have the rights to edit this bookmark");

      // Output form if everything is ok
      echo $twig->render('forms/bookmark-edit.html', $data);
      exit;

      break;
    // ******************
    //
    // DELETE
    //
    // ******************
    case 'delete':
      if(!isset($_SESSION['user_id'])) exit('You must be connected');
      // Check user rights
      if($_SESSION['rights'] < 2) exit("You don't have the rights to delete bookmarks");
      if(!isset($_GET['id'])) exit('No bookmark specified');
      $id = (int) $_GET['id'];
      if($id < 1) exit('Invalid ID');

      // Check DB
      require_once __DIR__.'/db.php';
      $req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
      $req->execute(array($id));
      $data = $req->fetch();
      if(!$data) exit("This bookmark doesn't exist");

      if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $req = $bdd->prepare("DELETE FROM bookmarks WHERE id = ?");
        if($req->execute(array($id))) exit('<p>Bookmark <b>'.$id.'</b> was deleted</p>');
        else exit('Failed to delete bookmark');
      }

      echo '<p>WARNING, you are about to delete the following bookmark:</p>';
      echo '<h3>'.$data['titre'].'</h3>';
      echo '<p>'.$data['url'].'</p>';
      echo '<p>Are you sure you wish to continue ?</p>';
      echo '<p><a href="./bookmark.php?id='.$id.'"><h3>No, Cancel</h3></a><a href="?action=delete&id='.$id.'&confirm=yes">Yes, Proceed</a></p>';

      break;
    default:
      echo 'Invalid action';
      exit;
      // header('Location: '.__DIR__.'/');
      break;
  }

}

// If no action but there's an ID, display bookmark
elseif(isset($_GET['id'])) {

  require_once __DIR__.'/db.php';

  $bookmark_id = (int) $_GET['id'];

  if($bookmark_id < 0) exit('invalid id');

  $req = $bdd->prepare("SELECT * FROM bookmarks WHERE id = ?");
  $req->execute(array($bookmark_id));
  $data = $req->fetch(PDO::FETCH_ASSOC);

  echo $twig->render('bookmark-display.html', $data);

}

else {
// header('Location: ./bookmarks.php');
  exit ('Invalid action');
}

?>
