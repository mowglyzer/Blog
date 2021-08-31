<?php

session_start();
include 'config/connect.php';
include 'config/functions.php';

if (isset($_SESSION['userEmail'])) {
  header('Location:../index.php');
}


if (isset($_POST['forminscription'])){

  $pseudo = htmlspecialchars($_POST['pseudo']);
  $email = htmlspecialchars($_POST['email']);
  $password = sha1($_POST['password']);
  $password_confirm = sha1($_POST['password_confirm']);
  date_default_timezone_set('Europe/Paris');
  $date = date('d/m/Y à H:i:s');

  if ((!empty($pseudo)) AND (!empty($email)) AND (!empty($password)) AND (!empty($password_confirm))) {
    if (strlen($pseudo) >= 2) {
     if (strlen($pseudo) <= 16) { 
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($password == $password_confirm) {

          $database = getPDO();
          $rowEmail = countDatabaseValue($database, 'user_email', $email);
          if ($rowEmail == 0) {

            $rowPseudo = countDatabaseValue($database, 'user_pseudo', $pseudo);
            if ($rowPseudo == 0) {

            $insertMember = $database->prepare("INSERT INTO users(user_pseudo, user_email, user_password, isadmin, isban, register_date) VALUES(?, ?, ?, ?, ?, ?)");
            $insertMember->execute([
              $pseudo,
              $email,
              $password,
              0,
              0,
              $date
            ]);


            $succesMessage = "Votre compte a bien été créer !";
            header('refresh:3 ; url=login.php');

            } else {
              $errorMessagePseudo1 = "Ce pseudo es déjà utilisé !";
            } 
          } else {
            $errorMessageMail1 = "Cette adresse mail est déjà utilisée !";
          }
        } else {
          $errorMessageMdp1 = "Vos mot de passes ne correspondent pas !";
        }
      } else {
        $errorMessageMail2 = "Votre email n'est pas valide !";
      }
    } else {
      $errorMessagePseudo2 = "Votre pseudo doit contenir moins de 16 caractères !";
    }
    }else {
    $errorMessagePseudo3 = "Votre pseudo doit contenir au moins 2 caractères !";
  }
  } else {
    $errorMessageGeneral = "Veuillez remplir tous les champs !";
  }
}





?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/register.css" />
    <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script> 
    <title>Inscription</title>
</head>

  
<body>

<?php include("header_other_page.php") ?>

    <!-- Content
            ================================================== -->
    <div class="page-content">
        <div class="page-content-inner">

            <div class="uk-width-2-5@m m-auto my-5">
                <div class="mb-4">
                    <h2 class="mb-0">Inscription</h2>
                    <p class="my-0">Accédez à toutes les fonctionnalités du site.</p>
                </div>
                <?php if (isset($errorMessageGeneral)) { ?> <p style="color : red;"><?=$errorMessageGeneral?></p> <?php } ?>
                <?php if (isset($succesMessage)) { ?> <p style="color : green;"><?=$succesMessage?></p> <?php } ?>
                <form class="default-ajax" data-recaptcha-v3-action="register" method="POST" action="">
                    <input type="hidden" name="token" value="8ad90566d885769e62556852238c5bd9d0ce09040843a46c33ac8fce4f1870a5">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-form-group">
                            <label class="uk-form-label" id="pseudo">Pseudo</label>
                            <?php if (isset($errorMessagePseudo1)) { ?> <p class="error_message" style="color : red;"><?=$errorMessagePseudo1?></p> <?php } ?>
                            <?php if (isset($errorMessagePseudo2)) { ?> <p class="error_message" style="color : red;"><?=$errorMessagePseudo2?></p> <?php } ?>
                            <?php if (isset($errorMessagePseudo3)) { ?> <p class="error_message" style="color : red;"><?=$errorMessagePseudo3?></p> <?php } ?>
                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                <input class="uk-input" type="text" name="pseudo" placeholder="Votre pseudo" autofocus required>
                            </div>
                        </div>

                        <div class="uk-form-group">
                            <label class="uk-form-label" id="email">Email</label>
                            <?php if (isset($errorMessageMail1)) { ?> <p class="error_message" style="color : red;"><?=$errorMessageMail1?></p> <?php } ?>
                            <?php if (isset($errorMessageMail2)) { ?> <p class="error_message" style="color : red;"><?=$errorMessageMail2?></p> <?php } ?>
                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input class="uk-input" type="email" name="email" placeholder="Votre adresse email" required>
                            </div>
                        </div>

                        <div class="uk-form-group">
                            <label class="uk-form-label" id="mdp">Mot de passe</label>
                            <?php if (isset($errorMessageMdp1)) { ?> <p class="error_message" style="color : red;"><?=$errorMessageMdp1?></p> <?php } ?>
                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input class="uk-input" type="password" name="password" placeholder="********" required>
                            </div>
                        </div>

                        <div class="uk-form-group">
                            <label class="uk-form-label" id="mdp">Confirmez votre de passe</label>
                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input class="uk-input" type="password" name="password_confirm" placeholder="********" required>
                            </div>
                        </div>

                        <div class="uk-form-group">
                            <div class="uk-position-relative w-101">
                                <label><input class="uk-checkbox" type="checkbox" name="newsletter"> Recevoir la newsletter (occasionnelle) du site</label><br>
                                <label><input class="uk-checkbox" type="checkbox" name="cgu" required> J'accepte les <a target="_blank" href="/mentions-legales-cgu/"></a>Conditions Générales d'Utilisation</a></label>
                            </div>
                        </div>

                        <div class="uk-form-group" id="reCaptchaV2"></div>

                        <div class="end" >
                            <div class="group_end">
                                <p><a class="links" href="login.php">Déjà un compte ?</a></p>
                                <button type="submit" name="forminscription"class="btn btn-primary">Je m'inscris</button>
                            </div>
                           
                        </div>
                        
                    </div>
                </form>
            </div>

        </div>
    </div>

<?php include("footer.php")?>

</body>

</html>