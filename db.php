<?php
    error_reporting(E_ALL);
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=lovelace_bookmarks;charset=utf8', 'root', 'user');


    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());

    }

// h // ??
// include 'db.php'; // ???
// $db = new DB(); // new db ? trop de changement par rapport à l'ancien et surtout pas vraiment de lien entre les deux, plus ajouts que changement.
// $tblName = 'pdo_users';
// if(isset($_REQUEST['action_type']) && !empty($_REQUEST['action_type'])){
//     if($_REQUEST['action_type'] == 'add'){
//         $userData = array(
//             'titre' => $_POST['titre'],
//             'url' => $_POST['url'],
//             'desciption' => $_POST['description']
//         );
//         $insert = $db->insert($tblName,$userData);
//         $statusMsg = $insert?'Your url has been inserted successfully.':'Some problem occurred, please try again.';
//         $_SESSION['statusMsg'] = $statusMsg;
//         header("Location:index.php");
//     }elseif($_REQUEST['action_type'] == 'edit'){
//         if(!empty($_POST['id'])){
//             $userData = array(
//                 'user' => $_POST['user'],
//                 'url' => $_POST['url'],
//                 'description' => $_POST['desciption']
//             );
//             $condition = array('id' => $_POST['id']); // ??
//             $update = $db->update($tblName,$userData,$condition);
//             $statusMsg = $update?'Your url has been updated successfully.':'Some problem occurred, please try again.';
//             $_SESSION['statusMsg'] = $statusMsg;
//             header("Location:index.php");
//         }
//     }elseif($_REQUEST['action_type'] == 'delete'){
//         if(!empty($_GET['id'])){
//             $condition = array('id' => $_GET['id']); // ??
//             $delete = $db->delete($tblName,$condition);
//             $statusMsg = $delete?'Your url has been deleted successfully.':'Some problem occurred, please try again.';
//             $_SESSION['statusMsg'] = $statusMsg;
//             header("Location:index.php");
//         }
//     } // acollade et crochet rouge ??, header location ???,
// }

?>
