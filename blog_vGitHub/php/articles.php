<?php
session_start();
    if(!isset($_GET['id']) OR !is_numeric($_GET['id']))
    header('Location: ../index.php');
    else
    {
        extract($_GET);
        $id = strip_tags($id);

        require_once('config/functions.php');

        if(!empty($_POST))
        {
            extract($_POST);
            $errors = array();

            $author = strip_tags($_SESSION['userPseudo']);
            $comment = strip_tags($comment);

            
            if(empty($comment))
            array_push($errors, 'Veuillez entrez un commentaire');

            if(count($errors) == 0)
            {
                $comment = addComment($id, $author, $comment);

                $success = 'Votre commentaire a bien été publié';

                unset($author);
                unset($comment);

                header('location : articles.php');
            }
        }

        $article = getArticle($id);
        $comments = getComment($id); 
    }  
    setlocale(LC_TIME, "fr_FR.utf8","fra");   
    $heure = new DateTime($article->date);
    $heurecom = new DateTime($com->date);

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article->title ?></title>
    <link rel="stylesheet" href="../css/articles.css">
    <link rel="stylesheet" href="../css/searchbarre.css">
    <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script>
    
</head>
<body>

<?php
session_start();
if (isset($_SESSION['userEmail'])) { ?>
        
    

<?php include("header_member_other.php")?>

<div class="content">
<div class="article_inner">
    <h1 class="title_article"><?= $article->title ?></h1>
</div>
<div class="article_content">
    <p><?= $article->content ?></p>
    <img class="file" src="upload/<?= $article->file?>" alt="">
    <p class="date"> Le <?php setlocale(LC_TIME, 'fr_FR.utf8','fra'); echo strftime("%A %d %B %G" , strtotime($article->date)); ?> à <?php echo $heure->format('H:i:s');?></p>
</div>

    <?php
    if(isset($sucess))
    echo $success;

    if(!empty($errors)):?>

        <?php foreach($errors as $error): ?>
        <p><?= $error ?></p>
        <?php endforeach; ?>

    <?php endif; ?>

    <form action="articles.php?id=<?= $article->id ?>" method="post">
   
       
        <div class="comm_after">
        <textarea name="comment" id="comment" placeholder="Ajouter un commentaire..." cols="30" rows="8"><?php if (isset($comment)) echo $comment ?></textarea>
        <button class="button_comm" type="submit">Envoyer</button>
        </div>
    </form>

    <h2>Commentaires :</h2>
        
    <?php foreach($comments as $com): ?>
        <div class="comm">
        <h3><?= $com->author ?></h3>
        <div class="comm_after_2">
        <p><?= $com->comment ?></p>
        <p class="date"> Le <?php setlocale(LC_TIME, 'fr_FR.utf8','fra'); echo strftime("%A %d %B %G" , strtotime($com->date)); ?> à <?php echo $heurecom->format('H:i:s');?></p>
        </div>
        </div>   
    <?php endforeach; ?> 
    
    </div>

        <?php include('footer.php')?>

<?php } else { ?>


    <?php include("header_other_page.php")?>

<div class="content">
<div class="article_inner">
    <h1 class="title_article"><?= $article->title ?></h1>
</div>
<div class="article_content">
    <p class="text_article"><?= $article->content ?></p>
    <img class="file" src="upload/<?= $article->file?>" alt="">
    <p class="date"> Le <?php setlocale(LC_TIME, 'fr_FR.utf8','fra'); echo strftime("%A %d %B %G" , strtotime($article->date)); ?> à <?php echo $heure->format('H:i:s');?></p>
    
</div>


    <?php
    if(isset($sucess))
    echo $success;

    if(!empty($errors)):?>

        <?php foreach($errors as $error): ?>
        <p><?= $error ?></p>
        <?php endforeach; ?>

    <?php endif; ?>

    <h2 class="msg_connect">Vous devez créer un compte pour poster un commentaire !</h2>

    <h2>Commentaires :</h2>
        
    <?php foreach($comments as $com): ?>
        <div class="comm">
        <h3><?= $com->author ?></h3>
        <div class="comm_after_2">
        <p><?= $com->comment ?></p>
        <p class="date"> Posté le <?php setlocale(LC_TIME, 'fr_FR.utf8','fra'); echo strftime("%A %d %B %G" , strtotime($com->date)); ?> à <?php echo $heurecom->format('H:i:s');?></p>
        </div>
        </div>   
    <?php endforeach; ?> 
    
    </div>

    <?php include('footer.php')?>

<?php } ?>

</body>
</html>