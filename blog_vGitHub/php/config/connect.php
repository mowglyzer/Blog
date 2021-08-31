<?php 
try{
    $bdd=new PDO('mysql:host=sql315.main-hosting.eu;dbname=u736683504_blog;charset=UTF8', 'u736683504_mowglyzer', 'VR9ruBDuX41ZE');
    $bdd->exec('SET NAMES "UTF8"');
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}


?>
