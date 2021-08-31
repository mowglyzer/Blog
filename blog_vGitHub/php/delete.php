<?php

$bdd=new PDO('mysql:host=sql315.main-hosting.eu;dbname=u736683504_blog;charset=UTF8', 'u736683504_mowglyzer', 'VR9ruBDuX41ZE');
session_start();

//Suppression de l'article
if (isset($_GET['id']) AND !empty($_GET['id'])) {

    $supp_id = htmlspecialchars($_GET['id']);

    $supp = $bdd->prepare("DELETE FROM `articles` WHERE `articles`.`id` = ?");
    $supp->execute(array($supp_id));

    header("location : admin.php");

}

?>