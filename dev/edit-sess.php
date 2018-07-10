<?php

session_start();

$_SESSION['user_id'] = isset($_GET['u']) ? intval($_GET['u']) : 1;
$_SESSION['rights'] = isset($_GET['r']) ? intval($_GET['r']) : 1;

echo '<p><a href="./">dev folder</a></p>';
echo '<p><a href="./dump-sess.php">dump sess</a></p>';

echo '<p>Session created with user ID <b>'.$_SESSION['user_id'].'</b> and rights level <b>'.$_SESSION['rights'].'</b></p>';

?>
