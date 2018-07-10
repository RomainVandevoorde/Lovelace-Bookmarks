<?php

function hasRights($level) {
  return (isset($_SESSION['user_id']) && isset($_SESSION['rights']) && $_SESSION['rights'] >= $level);
}

?>
