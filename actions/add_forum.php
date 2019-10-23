<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=wintoz', 'root', '');

    $addforum = $bdd->prepare("INSERT INTO forums(name, date, user_id) VALUES(?, UNIX_TIMESTAMP(), ?)");
    $addforum->execute(array($_POST['name'], $_SESSION['id']));
?>