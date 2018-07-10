<?php

session_start();

$_SESSION['user_id'] = 1;

if(isset($_GET['rights']) && intval($_GET['rights']) >= 0) {
  $_SESSION['rights'] = $_GET['rights'];
}
else $_SESSION['rights'] = 1;

echo '<p><a href="./">dev folder</a></p>';
echo '<p><a href="./dump-sess.php">dump sess</a></p>';

echo '<p>Session created with rights level <b>'.$_SESSION['rights'].'</b></p>';

?>
