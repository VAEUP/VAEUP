<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=wintoz', 'root', '');

    $addcat = $bdd->prepare("INSERT INTO forum_categories(name, description, last_message, last_date, subjects, id_forum, user_id) VALUES(?, ?, '-', '-', 0, ?, ?)");
    $addcat->execute(array($_POST['name'], $_POST['description'], $_POST['id_forum'], $_SESSION['id']));
?>