<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('config/functions.php');

//Affichage de la date au bon format en français
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR","French");   

$articles = getArticles();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Capsule Blog</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div class="content">
    <?php foreach($articles as $article): ?>
        <div class="container_articles">
            <img class="file" src="php/upload/<?= $article->file?>" alt="">
            <div class="full_content">
            <div class="entry_container">
            <p class="date"> Le <?php setlocale(LC_TIME, 'fr_FR.utf8','fra'); echo strftime("%A %d %B %G" , strtotime($article->date)); ?> </p>
            <p class="author">
            <?php 
            if (!empty($article->avatar)) { ?>
                <img class="avatar" src="php/avatars/<?= $article->avatar ?>" alt=""> 
                <? } else { ?>
                <div class="pseudo_membre"><? echo strtoupper(substr($article->author, 0, 1 )); ?></div>
            <? } ?>
            <?= ucfirst($article->author) ?>
            </p>
            </div>
            <div class="article_content">
            <h2><a href="php/articles.php?id=<?= $article->id ?>"><?= $article->title ?></a></h2>
            <p><?php echo substr($article->content, 0, 300 ).'...'; ?></p>
            </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    
</body>
</html>