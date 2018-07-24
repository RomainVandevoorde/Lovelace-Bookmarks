<?php

session_start();

echo '<p><a href="./">dev folder</a></p>';

?>
<table>
  <tr>
    <th>Key</th>
    <th>Value</th>
  </tr>
<?php

foreach($_SESSION as $key => $value) {
  echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
}


?>

</table>
