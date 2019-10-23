<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=wintoz', 'root', '');

    $redirect = $_POST['id_categorie'];
    $addthread = $bdd->prepare("INSERT INTO forum_threads(name, id_user, date, answers, views, last_date, content, closed, id_categorie, user_id) VALUES(?, ?, UNIX_TIMESTAMP(), 0, 0, 0, ?, 0, ?, ?)");
    $addthread->execute(array($_POST['name'], $_POST['id_user'], $_POST['content'], $_POST['id_categorie'], $_SESSION['id']));

    $reqcat = $bdd->prepare("SELECT * FROM forum_categories WHERE id = $redirect");
    $reqcat->execute(array());
    $getcat = $reqcat->fetch();

    $subjects = $getcat['subjects'] + 1;

    $addcat = $bdd->prepare("UPDATE forum_categories SET last_message = ?, last_date = UNIX_TIMESTAMP(), subjects = ? WHERE id = $redirect");
    $addcat->execute(array($_POST['name'], $subjects));

    header('Location: ../forum/forum_categorie.php?id='.$redirect);
?>