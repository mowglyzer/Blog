<?php
require('config/connect.php');

session_start();

$mode_edition = 0;

//Modification de l'article
if (isset($_GET['edit']) AND !empty($_GET['edit'])) {
 
    $mode_edition = 1;
    $edit_id = htmlspecialchars($_GET['edit']);
    $edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ? ');
    $edit_article->execute(array($edit_id));

    if($edit_article->rowCount() == 1) {

        $edit_article = $edit_article->fetch();

    } else {
        die('Erreur : L\'article n\'existe pas...');
    }
}



// Ajout d'un article en BDD
if(isset($_POST['article_title'], $_POST['article_content'])) {
    if(!empty($_POST['article_title']) AND !empty($_POST['article_content'])) {

        $article_title = htmlspecialchars(($_POST['article_title']));
        $article_content = htmlspecialchars($_POST['article_content']);
        $author = strip_tags($_SESSION['userPseudo']);
        $avatar = strip_tags($_SESSION['userAvatar']);

       
        if($mode_edition == 0) {
            
            if (isset($_FILES['uploaded_file'])) {
            $tmpName = $_FILES['uploaded_file']['tmp_name'];
            $name = $_FILES['uploaded_file']['name'];
            $size = $_FILES['uploaded_file']['size'];
            $error = $_FILES['uploaded_file']['error'];
            $type = $_FILES['uploaded_file']['type'];
                  
            // Récupère l'extensioin du fichier uploader
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
                  
            // Tableau des extensions qu'on autorise
            $extensionsAutorisees = ['jpg', 'jpeg', 'gif', 'png', 'svg', 'pdf',  'mp4', 'mov', 'txt', 'py'];
                  
            // Taille maximum du fichier uploader
           $maxSize = 2097152;
                  
            if(in_array($extension, $extensionsAutorisees) && $error == 0 ) {
                if($size <= $maxSize) {


                    $ins = $bdd->prepare('INSERT INTO articles (title, content, date, file, author, avatar) VALUES (?, ?, NOW(), ?, ?, ?)');
                    $ins->execute(array($article_title, $article_content, $name, $author, $avatar));

                    move_uploaded_file($tmpName, './upload/' . $name);

                    $successMessage = 'Votre article a bien été publié !';
                    header('refresh : 1 ; url=../index.php'); 

                    
                    } else {
                        $errorMessageSize = "Ce fichier est trop volumineux";
                    }


                      } else {

                        $errorMessageExt = "Ce fichier n'a pas la bonne extension";
                    }  

                    } else {
                        $errorMessageChamps = 'Veuillez remplir tous les champs';
                    }

        } else {
            $update = $bdd->prepare('UPDATE `articles` SET `title` = ?, `content` = ?, `date_time_edition` = NOW() WHERE `id` = ?');
            $update->execute(array($article_title, $article_content, $edit_id));
            $successMessage = "Votre article a bien été mis a jour !";
            header('refresh : 1 ; url=admin.php');
        }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postez / Editez</title>
    <link rel="stylesheet" href="../css/post_article.css">
</head>
<body>

<?php 
session_start();
if ($_SESSION['userAdmin'] == 1) { ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="article_title" placeholder="Titre" <?php if($mode_edition == 1) { ?> value="<?= $edit_article['title'] ?>"<?php } ?>/>
    <textarea name="article_content" placeholder="Contenu de l'article" id="" cols="30" rows="10"><?php if($mode_edition == 1) { ?><?= $edit_article['content'] ?><?php } ?></textarea>
    <input type="file" name="uploaded_file"/>
    <input type="submit" name="submit" value="Publier l'article !"/>
</form>

<?php if(isset($errorMessageChamps)) { ?> <p style="color : red;"><?=$errorMessageChamps?></p> <?php } ?>
<?php if(isset($successMessage)) { ?> <p style="color : green;"><?=$successMessage?></p> <?php } ?>
<?php if (isset($errorMessageExt)) { ?> <p style="color : red;"><?=$errorMessageExt?></p> <?php } ?>
<?php if (isset($errorMessageSize)) { ?> <p style="color : red;"><?=$errorMessageSize?></p> <?php } ?>

<div class="side-bar">
    <a href="../index.php"><img class="menu" src="../img/menu.png" alt=""></a>

    <div class="social-links">
        <img src="../img/fb.png" alt="">
        <img src="../img/ig.png" alt="">
        <img src="../img/tw.png" alt="">
    </div>

    <div class="useful-links">
        <img src="../img/share.png" alt="">
        <img src="../img/info.png" alt="">
    </div>
            
</div>

<?php } else { ?>
    
<h2 class="msg_admin">Vous devez être Administrateur pour poster un article !</h2>

<?php } ?>

</body>
</html>