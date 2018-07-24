<?php

$content = scandir(__DIR__);

echo '<p><a href="../">Top folder</a></p>';

foreach($content as $c) {
  if($c === '.' || $c === '..') continue;

  echo '<li><a href="'.$c.'">'.$c.'</a></li>';

}


?>
