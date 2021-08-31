<!DOCTYPE html>
<html lang="fr">
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
        <h1><a href="../index.php" class="title">Blog</a></h1>
            <div class="header_search">
            <form method="GET" class="form_search" action="php/verif-form.php">
                <input type="search" name="terme" class="input_search" placeholder="Rechercher.." />
                <button type = "submit" name = "s" value = "Rechercher" class="btn_search" >
                    <i class="fas fa-search"></i>
                </button>
            </form>
            </div>
        </div>
    
        <div class="connexion">
            <a class="register" href="register.php">S'inscrire</a>
            <a class="connect" href="login.php">Se connecter</a>
        </div>
    </div>
</header>
    
</body>
</html>