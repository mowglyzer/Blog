<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/searchbarre.css">
</head>
<body>

<header>
    <div class="header_content">
        <h1><a class="blog_title" href="index.php">Blog</a></h1>
            <form method="GET" class="form_search" action="php/verif-form.php">
                <input type="search" name="terme" class="input_search" placeholder="Rechercher.." />
                <button type = "submit" name = "s" value = "Rechercher" class="btn_search" >
                    <i class="fas fa-search"></i>
                </button>
            </form>
    
        <div class="connexion">
            <a class="register" href="page_inscription.php">S'inscrire</a>
            <a class="connect" href="page_connexion.php">Se connecter</a>
        </div>
    </div>
</header>
    
</body>
</html>