<?php 

session_start();
include 'config/connect.php';
include 'config/functions.php';

if (!isset($_SESSION['userEmail'])) {
    header('Location:index.php');
}


// Selection de la table users et articles
$database = getPDO();
$members = $database->query('SELECT * FROM users');
$article = $database->query('SELECT * FROM articles');


// Récupère les infos client avec $userInfo
$clientID;
$userCount;
$userInfo;
if (isset($_GET['id'])) {
    $clientID = $_GET['id'];
    $requestUser = $database->prepare("SELECT * FROM users WHERE user_id = ?");
    $requestUser->execute(array($clientID));
    $userCount = $requestUser->rowCount();
    $userInfo = $requestUser->fetch();
}


// Récupère les infos articles
$articleID;
$articleCount;
$articleInfo;
if (isset($_GET['id'])) {
    $articleID = $_GET['id'];
    $requestArticle = $database->prepare("SELECT * FROM articles WHERE id = ?");
    $requestArticle->execute(array($articleID));
    $articleCount = $requestArticle->rowCount();
    $articleInfo = $requestArticle->fetch();
}

// Edit
if (isset($_POST['edit'])) {
    $userEmail = $userInfo['user_email'];
    $userPseudo = $userInfo['user_pseudo'];
    $emailValue = htmlspecialchars($_POST['email']);
    $pseudoValue = htmlspecialchars($_POST['pseudo']);

    if ($userEmail != $emailValue) {
        $rowEmail = countDatabaseValue($database, 'user_email', $emailValue);
        if ($rowEmail == 0) {
            $request = $database->prepare("UPDATE users SET user_email = ? WHERE user_email = ?");
            $request->execute([
                $emailValue,
                $userEmail
            ]);
            $succesMessage = 'Les informations ont bien été modifiés!';
        } else {
            $errorMessage = 'Cette adresse email existe déjà !';
        }
        header('refresh:3;url=admin.php');
    }

    if ($userPseudo != $pseudoValue) {
        $rowPseudo = countDatabaseValue($database, 'user_pseudo', $pseudoValue);
        if ($rowPseudo == 0) {
            $request = $database->prepare("UPDATE users SET user_pseudo = ? WHERE user_pseudo = ?");
            $request->execute([
                $pseudoValue,
                $userPseudo
            ]);
            $succesMessage = 'Les informations ont bien été modifiés!';
        } else {
            $errorMessage = 'Ce pseudo existe déjà !';
        }
        header('refresh:3;url=admin.php');
    }
}

// Suppresion du Compte
if (isset($_POST['delete'])) {
    $request = $database->prepare('DELETE FROM users WHERE user_email = ?');
    $request->execute([
        $userInfo['user_email'],
    ]);
    header('Location:admin.php');
}

// Ban Système
if ((isset($_POST['ban'])) || isset($_POST['unban'])) {

    $banValue = 0;
    if ($userInfo['isban'] == 0) {
        $banValue = 1;
    }
    $request = $database->prepare("UPDATE users SET isban = ? WHERE user_email = ?");
    $request->execute([
        $banValue,
        $userInfo['user_email']
    ]);
    $succesMessage = "Vous venez de " . ($banValue == 0 ? 'Débannir' : 'Bannir') . ' le client!';
    header('refresh:3;url=admin.php');
}

// Admin Système 

if ((isset($_POST['admin'])) || isset($_POST['unadmin'])) {

    $adminValue = 0;
    if ($userInfo['isadmin'] == 0) {
        $adminValue = 1;
    }
    $request = $database->prepare("UPDATE users SET isadmin = ? WHERE user_email = ?");
    $request->execute([
        $adminValue,
        $userInfo['user_email']
    ]);
    $succesMessage = "Vous venez de " . ($adminValue == 0 ? 'retirer Admin' : 'mettre Admin') . ' le client!';
    header('refresh:3;url=admin.php');
}



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Espace Client - Admin</title>
        <link rel="stylesheet" type="text/css" href="../css/admin.css">
    </head>
    <body>
        <?php include("header_member_other.php");?>

        <div class="content">
            
        <a href="post_articles.php" class="post_article_link">Postez un article !</a>
        
            <div class="admin_panel">
                <div class="inner">
                    <h3 class="title">Panel Admin</h3>
                    <?php if ($_SESSION['userAdmin'] == 1) { ?>
                    <ul>
                    <?php while($users = $members->fetch()) {?>
                    <li><?= $users['user_email'] ?> - <?= $users['user_pseudo'] ?> - <a href="admin.php?id=<?= $users['user_id'] ?>">Gérer</a></li>
                    <?php } ?>
                    </ul>
                    <ul>
                    <?php while($articles = $article->fetch()) {?>
                    <li><?= $articles['title'] ?> - <a href="post_articles.php?edit=<?= $articles['id'] ?>">Modifier</a> - <a href="delete.php?id=<?= $articles['id'] ?>">Supprimer</a></li>
                    <?php } ?>
                    </ul>
                </div>
                <div class="after">     
                    <?php if (isset($clientID)) { 
                        if ($userInfo == null) { echo "Ce compte n'existe pas !"; } else { ?>
                        
                        <h3 class="title">Gérer : <?= $userInfo['user_pseudo'] ?></h3>

                        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
                        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
                        
                        <form method="post" action="">
                            <span>Email :</span><br>
                            <input class="group_input" type="email" name="email" placeholder="Email" value="<?= $userInfo['user_email'] ?>"><br>

                            <span>Pseudo :</span><br>
                            <input class="group_input" type="text" name="pseudo" placeholder="Pseudo" value="<?= $userInfo['user_pseudo'] ?>"><br><br>
                            
                            <div class="group_submit">
                            <input class="submit" type="submit" name="edit" value="Editer">
                            <input class="submit" type="submit" name="delete" value="Supprimer le Compte">
                            <?php if($userInfo['isban'] == 0) {?>
                                <input class="submit" type="submit" name="ban" value="Bannir">
                            <?php } else { ?>
                                <input class="submit" type="submit" name="unban" value="DéBannir">
                            <?php } ?>
                            <?php if($userInfo['isadmin'] == 0) {?>
                                <input class="submit" type="submit" name="admin" value="Admin">
                            <?php } else { ?>
                                <input class="submit" type="submit" name="unadmin" value="UnAdmin">
                            <?php } ?>
                            </div>
                        </form>
                </div>   

                    <?php } } ?>
                <?php } else { ?>
                <p style="color: red;">Vous devez être Admin pour accéder à cette page !</p>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
