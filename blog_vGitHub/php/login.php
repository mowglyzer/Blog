<?php

session_start();
include ('config/connect.php');
include ('config/functions.php');

if (isset($_SESSION['userEmail'])) {
    header('Location:../index.php');
}

if (isset($_POST['formconnexion'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
  $email = htmlspecialchars($_POST['email']);
  $password = sha1($_POST['password']);

  if ( (!empty($pseudo)) && (!empty($email)) && (!empty($password)) ) {

    $database = getPDO();
    $requestUser = $database->prepare("SELECT * FROM users WHERE user_pseudo = ? AND user_email = ? AND user_password = ?");
    $requestUser->execute(array($pseudo, $email, $password));
    $userCount = $requestUser->rowCount();

    if ($userCount == 1) {
      
      $userInfo = $requestUser->fetch();
      $_SESSION['userID'] = $userInfo['user_id'];
      $_SESSION['userPseudo'] = $userInfo['user_pseudo'];
      $_SESSION['userEmail'] = $userInfo['user_email'];
      $_SESSION['userPassword'] = $userInfo['user_password'];
      $_SESSION['userAdmin'] = $userInfo['isadmin'];
      $_SESSION['userBan'] = $userInfo['isban'];
      $_SESSION['userRegisterDate'] = $userInfo['register_date'];
      $_SESSION['userAvatar'] = $userInfo['avatar'];
      $succesMessage = "Vous êtes maintenant connecté !";
      header('refresh:1;url=../index.php'); 
        
    } else {
      $errorMessage = "Email, pseudo ou mot de passe incorrect !";
    }


  } else {
    $errorMessage = "Veuillez remplir tout les champs !";
  }

}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="../css/login.css"/> 
  <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script>
</head>



<body>

<?php include("header_other_page.php")?>

    <div class="page_content">
                <div class="inner"> 
                    <h2 class="title">Connexion</h2>
                    <p class="sous_title">Accédez a toutes les fonctionnalités du site.</p>
                    <?php if (isset($errorMessage)) { ?> <p style="color : red;"><?=$errorMessage?></p> <?php } ?>
                    <?php if (isset($succesMessage)) { ?> <p style="color : green;"><?=$succesMessage?></p> <?php } ?>
                </div>
                <form action="" method="post" name="login" class="form_connect">
                <input type="hidden" name="token" value="8ad90566d885769e62556852238c5bd9d0ce09040843a46c33ac8fce4f1870a5">
                <div class="content"> 
                    <div class="group_formulaire">
                        <label class="group_label" id="pseudo">Pseudo</label>
                        <div class="champs"> 
                            <span class="icons"> 
                            <i class="fas fa-users"></i>
                            </span>
                            <input type="text" class="input" name="pseudo" placeholder="Votre pseudo" autofocus >
                        </div>
                    </div>
                    <div class="group_formulaire">
                        <label class="group_label" id="mail">Email</label>
                        <div class="champs"> 
                            <span class="icons"> 
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="text" class="input" name="email" placeholder="Votre email" autofocus  >
                        </div>
                    </div>
                    <div class="group_formulaire"> 
                        <label class="group_label" id="mdp">Mot de passe <a class="links" href="" class="oublie">Mot de passe oublié ?</a></label>
                        <div class="champs"> 
                            <span class="icons"> 
                                <i class="fas fa-lock"></i>
                            </span>
                        <input type="password" class="input" name="password" placeholder="***********" autofocus >
                        </div>
                    </div>
                    <div class="group_formulaire"> 
                        <label class="remember_me"><input class="checkbox" type="checkbox" name="remember_me" checked>Se souvenir de moi</label>
                    </div>
                    <div class="end"> 
                        <div class="group_end">
                            <p><a class="links" href="login.php">Pas encore de compte?</a></p>
                        </div>
                        <div class="group_end2"> 
                            <button type="submit" name="formconnexion" class="first_button">Connexion</button>
                        </div>
                    </div>
                </div>
                </form>
    </div>

<?php include("footer.php")?>

</body>

</html>