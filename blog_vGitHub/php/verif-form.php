<?php
require('config/connect.php');
require('config/functions.php');

//Mettre l'affichage de la date en francais au format J/M/A
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, "fr_FR","French");   

$articles = getArticles();

$bdd->query("SET NAMES UTF8"); 

if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
{
 $_GET['terme'] = htmlspecialchars($_GET['terme']); //pour sécuriser le formulaire contre les intrusions html
 $terme = $_GET['terme'];
 $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
 $terme = strip_tags($terme); //pour supprimer les balises html dans la requête; 


 if (isset($terme))
 {
   //Récupérer les informations en BDD
  $terme = strtolower($terme);
  $select_terme = $bdd->prepare('SELECT id, title, content, date, file FROM articles WHERE title LIKE ? OR content LIKE ?');
  $select_terme->execute(array("%".$terme."%", "%".$terme."%"));
 }
 else
 {
  $message = 'Vous devez entrer votre requete dans la barre de recherche';
 }
}
 

?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset = "utf-8" >
  <title>LaCapsule Blog</title>
  <link rel="stylesheet" type="text/css" media="all" href="../css/main.css">
  <link rel="stylesheet" type="text/css" media="all" href="../css/searchbarre.css">
  <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script>
 </head>
 
<body>


<?php 
session_start();
if (isset($_SESSION['userEmail'])){ ?> 

<?php include("header_member_other.php")?>

<div class="content_search">
    <h2 class="titre_recherche">Résultats pour « <?=$terme?> »</h2>
  <?php
  while($terme_trouve = $select_terme->fetch()){ 
  ?>
      <div class="container_articles_recherche">
        <img class="file" src="upload/<?= $terme_trouve['file'] ?>" alt="">
        <div class="entry_container">
        <h2><a href="articles.php?id=<?= $terme_trouve['id'] ?>"><?= $terme_trouve['title'] ?></a></h2>
        <p class="date"> Le <?php echo strftime("%A %d %B %G" , strtotime($terme_trouve->date)); ?> </p>
        <p><?= substr($terme_trouve['content'],0,185).'...';?></p>
        </div>
      </div> 
  <?php 
  }
   $select_terme->closeCursor();
  ?>
</div> 


<div class="content">
    <?php foreach($articles as $article): ?>
        <div class="container_articles">
            <img class="file" src="upload/<?= $article->file?>" alt="">
            <div class="entry_container">
            <p class="date"> Le <?php echo strftime("%A %d %B %G" , strtotime($article->date)); ?> </p>
            <h2><a href="articles.php?id=<?= $article->id ?>"><?= $article->title ?></a></h2>
            <p><?php echo substr($article->content, 0, 300 ).'...'; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include("footer.php")?>

<?php } else { ?>

<?php include("header_other_page_search.php")?>

<div class="content_search">
    <h2 class="titre_recherche">Résultats pour « <?=$terme?> »</h2>
  <?php
  while($terme_trouve = $select_terme->fetch()){ 
  ?>
      <div class="container_articles_recherche">
        <img class="file" src="upload/<?= $terme_trouve['file'] ?>" alt="">
        <div class="entry_container">
        <h2><a href="articles.php?id=<?= $terme_trouve['id'] ?>"><?= $terme_trouve['title'] ?></a></h2>
        <p class="date"> Le <?php echo strftime("%A %d %B %G" , strtotime($terme_trouve['date'])); ?> </p>
        <p><?= substr($terme_trouve['content'],0,185).'...';?></p>
        </div>
      </div> 
  <?php 
  }
   $select_terme->closeCursor();
  ?>
</div> 

<div class="content">
    <?php foreach($articles as $article): ?>
        <div class="container_articles">
            <img class="file" src="upload/<?= $article->file?>" alt="">
            <div class="entry_container">
            <p class="date"> Le <?php echo strftime("%A %d %B %G" , strtotime($article->date)); ?> </p>
            <h2><a href="articles.php?id=<?= $article->id ?>"><?= $article->title ?></a></h2>
            <p><?php echo substr($article->content, 0, 300 ).'...'; ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

  <?php include("footer.php")?>

<?php } ?>

 </body>
</html>