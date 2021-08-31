<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('php/config/functions.php');

session_start();


$articles = getArticles();
?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Capsule Blog</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/main.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/searchbarre.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/header.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/footer.css">
    <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script>
</head>
<body>

<?php if (isset($_SESSION['userEmail'])){ ?> 

    <?php if ($_SESSION['userAdmin'] == 1) { ?>

        <?php if (($_SESSION['userBan'] != null) && ($_SESSION['userBan'] == 1)) { ?>

        <div class="ban">
        <p><b>!!! VOUS ETES BANNI !!!</b></p>
        <img src="img/banned.jpg" alt="">
        <img src="img/dab_gif.gif" alt="">
        <a href="php/logout.php">Déconnexion</a>
        </div>
        
        <?php }  else { ?>

        <?php include("php/header_member.php") ?>

        <h2 class="welcome">Bonjour cher Administrateur <?= $_SESSION['userPseudo']; ?> !</h2>
        <p class="welcome">Vous pouvez gérer ce Blog et accéder a votre Panel Admin avec le bouton ci dessous</p>
        <a href="php/admin.php" class="admin_link">Pannel Admin</a>

        <?php include("php/articles_principales.php")?>

        <?php include("php/footer.php")?>
            
        <?php }  } else { ?>

    <?php if (($_SESSION['userBan'] != null) && ($_SESSION['userBan'] == 1)) { ?>

    <div class="ban">
    <p><b>!!! VOUS ETES BANNI !!!</b></p>
    <img src="img/banned.jpg" alt="">
    <img src="img/dab_gif.gif" alt="">
    </div>

    <?php }  else { ?>

    <?php include("php/header_member.php") ?>

    <h2 class="welcome">Bonjour, <?= $_SESSION['userPseudo']; ?> !</h2>

    <?php include("php/articles_principales.php")?>

    <?php include("php/footer.php")?>

<?php } } } else { ?>

<?php include("php/header_not_member.php") ?>

<?php include("php/articles_principales.php")?>

<?php include("php/footer.php")?>

<?php } ?>
    
</body>
</html>