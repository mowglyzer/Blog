<?php 

session_start();
include 'config/functions.php';
include 'config/connect.php'; 

//Ajout de l'avatar du membre
if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 2097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "./avatars/".$_SESSION['userID'].".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $database = getPDO();
            $updateavatar = $database->prepare('UPDATE users SET avatar = :avatar WHERE users . user_id = :id;');
            $updateavatar->execute(array(
               'avatar' => $_SESSION['userID'].".".$extensionUpload,
               'id' => $_SESSION['userID']
            ));
            $succesMessage = "Avatar upload";
         } else {
            $errorMessage = "Erreur durant l'importation de votre photo de profil";
         }
      } else {
         $errorMessage = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   } else {
      $errorMessage = "Votre photo de profil ne doit pas dépasser 2Mo";
   }
}


if (isset($_POST['submit_password'])) {

    $newPassword = sha1($_POST['password']);
    $confirmNewPassword = sha1($_POST['confirm_password']);
    $_SESSION['userPassword'];
    


        if ($newPassword == $confirmNewPassword) {
            
            $database = getPDO();
            $request = $database->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
            $request->execute([
                $newPassword,
                $_SESSION['userEmail']
            ]);
            $succesMessage = 'Votre mot de passe a bien été modifié !';
            header('refresh:3;url=../index.php');

        } else {
            $errorMessage = 'Les mots de passes ne sont pas identiques !';
        }
    } 


if (isset($_POST['submit_mail'])) {

    $newMail = htmlspecialchars($_POST['mail']);
    $confirmNewMail = htmlspecialchars($_POST['confirm_mail']);
    $_SESSION['userEmail'];
    

    if ($newMail == $confirmNewMail) {
        
            
            $database = getPDO();
            $request = $database->prepare("UPDATE users SET user_email = ? WHERE user_email = ?");
            $request->execute([
                $newMail,
                $_SESSION['userEmail']
            ]);
            $succesMessage = 'Votre adresse mail a bien été modifié !';
            header('refresh:3;url=../index.php');

        } else {
            $errorMessage = 'Les adresses mails ne sont pas identiques !';
    }
} 

?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="../css/my_account.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>

<body>

<?php include('header_member_other.php') ?>
<div class="content">
    <h2>Paramètres du compte</h2>

    <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
    <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>

    <div class="container_account">
        <div class="inner">

        <h3>Informations du compte</h3>
        <h3 class="center">Bonjour, <?= $_SESSION['userPseudo'] ?> !</h3>
        <h3>Nom d'utilisateur</h3>
        <h3 class="center"><?= $_SESSION['userPseudo'] ?></h3>
        <h3>Email</h3>
        <h3 class="center"><?= $_SESSION['userEmail'] ?></h3>
        <p class="bold">Inscrit le <?= $_SESSION['userRegisterDate'] ?></p>
        
        </div>

        <div class="after">

        <h3>Ajouter un avatar</h3>

        <?php if (isset($msg)) { ?> <p style="color: red;"><?= $msg ?></p> <?php } ?>

        <form action="my_account.php" method="post" enctype="multipart/form-data">

            <input type="file" name="avatar"/>
            <input class="button center" type="submit" name="submit" value="Publier l'avatar !"/>

        </form>

        <h3>Changer de mot de passe</h3>
                        
        <form method="post" action="">
    
            <span>Nouveau mot de passe :</span>
            <input type="password" name="password" placeholder="Nouveau mot de passe">
      
            <span>Confirmation du nouveau mot de passe :</span>
            <input type="password" name="confirm_password" placeholder="Confirmation mot de passe">
            <input class="button center" type="submit" name="submit_password" value="Valider">
        </form>
        <h3>Changer d'adresse mail</h3>
                        
        <?php if (isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p> <?php } ?>
        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p> <?php } ?>
                        
        <form method="post" action="">

            <span>Nouvelle adresse mail :</span>
            <input type="email" name="mail" placeholder="Nouvelle adresse mail">
      
            <span>Confirmation de la nouvelle adresse mail :</span>
            <input type="email" name="confirm_mail" placeholder="Confirmation adresse mail">
            <input class="button center" type="submit" name="submit_mail" value="Valider">
        </form>
        </div>
    </div>
</div>
</body>
</html>
