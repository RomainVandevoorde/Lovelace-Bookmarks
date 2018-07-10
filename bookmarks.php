<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style media="screen">
      td {
        padding:10px;
      }
    </style>
</head>
<body>
    <table>
      <tr>
        <th>ID</th>
        <th>Titre</th>
        <th>URL</th>
        <th>Description</th>
        <th>User</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
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
            echo '<td><a href="bookmark.php?action=edit&id='.$data['id'].'">Edit</a> <a href="?action=delete&id='.$data['id'].'">Delete</a></td>';
            echo '</tr>';
            }
            $rep->closeCursor();
        ?>
    </table>
    <a href="bookmark.php?action=add">Create a new bookmark</a>
</body>
</html>
