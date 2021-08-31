<?php
require('config/connect.php');

$articles = $bdd->query('SELECT title FROM articles ORDER BY id DESC');

if(isset($_GET['search']) AND !empty($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
    $articles = $bdd->query('SELECT title FROM articles WHERE title LIKE "%'.$search.'%" ORDER BY id DESC');
    if($articles->rowCount() == 0) {
        $articles = $bdd->query('SELECT title FROM articles WHERE CONCAT(title, content) LIKE "%'.$search.'%" ORDER BY id DESC');
     }
}
