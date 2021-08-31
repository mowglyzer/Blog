<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/searchbarre.css">
    <script src="https://kit.fontawesome.com/43ff92830f.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <div class="header_content">
        <div class="header_inner">
        <h1><a href="index.php">Blog</a></h1>
            <div class="header_search">
            <form method="GET" class="form_search" action="php/verif-form.php">
                <input type="search" name="terme" class="input_search" placeholder="Rechercher.." />
                <button type = "submit" name = "s" value = "Rechercher" class="btn_search" >
                    <i class="fas fa-search"></i>
                </button>
            </form>
            </div>
        </div>
    
        <div class="connexion_membre">

            <a class="myaccount" href="php/my_account.php">Mon compte</a>
            <a class="deconnect" href="php/logout.php">Déconnexion</a>
            <?php 
            if (!empty($_SESSION['avatar'])) { ?>
                <img class="avatar" src="php/avatars/<?= $_SESSION['avatar']; ?>" alt=""> 
                <? } else { ?>
                <div class="pseudo_membre"><?php echo strtoupper(substr($_SESSION['userPseudo'], 0, 1 )); ?></div>
            <? } ?>
            
        </div>
    </div>
</header>
    
</body>
</html>