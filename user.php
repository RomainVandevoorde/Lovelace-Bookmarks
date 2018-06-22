<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table>
        <?php
            require('db.php');

            $rep = $bdd->query('SELECT * FROM `users`');
            while ($data = $rep->fetch()) {
            echo '<tr>';
            echo '<td>'.$data['firstname'].'</td>';
            echo '<td>'.$data['lastname'].'</td>';
            echo '<td>'.$data['github-id'].'</td>';
            echo '<td>'.$data['rights'].'</td>';
            echo '</tr>';
            }
        ?>
    </table>
</body>
</html>