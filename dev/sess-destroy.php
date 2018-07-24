<?php

session_start();

echo '<p><a href="./">dev folder</a></p>';

$_SESSION = array();

echo '<p>Session data wiped</p>';


?>
