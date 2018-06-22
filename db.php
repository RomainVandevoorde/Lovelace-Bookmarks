<?php
    error_reporting(E_ALL);
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=lovelace_bookmarks;charset=utf8', 'root', 'darkangel');
    
    
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    
    }
?>