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

            $rep = $bdd->query('SELECT * FROM `bookmarks`');
            while ($data = $rep->fetch()) {
            echo '<tr>';
            echo '<td>'.$data['id'].'</td>';
            echo '<td>'.$data['titre'].'</td>';
            echo '<td>'.$data['url'].'</td>';
            echo '<td>'.$data['description'].'</td>';
            echo '<td>'.$data['user_added'].'</td>';
            echo '<td>'.$data['category_id'].'</td>';
            echo '</tr>';
            }
        ?>
    </table>  
</body>
</html>
