<?php
// FONCTION QUI RECUPERE TOUT LES ARTICLES
function getArticles()
{
    require('connect.php');
    $req = $bdd->prepare('SELECT id, title, content, date, file, author, avatar FROM articles ORDER BY id DESC');
    $req->execute();
    $data = $req->fetchALL(PDO::FETCH_OBJ);
    return $data;
    $req->closeCursor();
}
// FONCTION QUI RECUPERE UN ARTICLE
function getArticle($id)
{
    require('connect.php');
    $req = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $req->execute(array($id));
    if($req->rowCount() == 1)
    {
        $data = $req->fetch(PDO::FETCH_OBJ);
        return $data;    
    }
    else
        header('Location: ../../index.php');
        $req->closeCursor();
}
// FONCTION QUI AJOUTE UN COMMENTAITRE EN BDD
function addComment($articleid, $author, $comment)
{
    require('connect.php');
    $req = $bdd->prepare('INSERT INTO comment (articleid, author, comment, date) VALUES (?, ?, ?, NOW())');
    $req->execute(array($articleid, $_SESSION['userPseudo'], $comment));
    $req->closeCursor(); 
}
// FONCTION QUI AJOUTE UN COMMENTAITRE EN BDD QUAND ON ES MEMBRE
function addCommentMember($articleid, $comment)
{
    require('connect.php');
    $req = $bdd->prepare('INSERT INTO comment (articleid, comment, date) VALUES (?, ?, NOW())');
    $req->execute(array($articleid, $comment));
    $req->closeCursor(); 
}
//FONCTION QUI RECUPERE LES COMMENTAIRES D'UN ARTICLE
function getComment($id)
{
    require('connect.php');
    $req = $bdd->prepare('SELECT * FROM comment WHERE articleid = ?');
    $req->execute(array($id));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req->closeCursor();
}

//FONCTION QUI COMPTE EN BDD
function countDatabaseValue($connexionBDD, $key, $value) {
    $request = "SELECT * FROM users WHERE $key = ?";
    $rowCount = $connexionBDD->prepare($request);
    $rowCount->execute(array($value));
        return $rowCount->rowCount();

}

//FONCTION QUI SE CONNECTE EN BDD
function getPDO() {
    try {
        $bdd=new PDO('mysql:host=sql315.main-hosting.eu;dbname=u736683504_blog;charset=UTF8', 'u736683504_mowglyzer', 'VR9ruBDuX41ZE');
        $bdd->exec('SET CHARACTER SET utf8');
            return $bdd;
    } catch (PDOException $e) {
        var_dump($e);
    }
}





?>

