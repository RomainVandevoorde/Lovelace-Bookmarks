<?php

require 'includes/global.php';

if(isset($_GET['action'])) {

  switch ($_GET['action']) {
    case 'add':

      echo $twig->render('form-bookmark-add.html');

      break;

    default:
      echo 'Tu veux faire quoi wesh ?';
      break;
  }

}

?>
