<?php

session_start();

if(isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
if(isset($_SESSION['rights'])) unset($_SESSION['rights']);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Logout</title>
  </head>
  <body>
    <script type="text/javascript">
      window.onload = () => {
        window.location.replace("index.php");
      }
    </script>
  </body>
</html>
