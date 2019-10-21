<?php
$bdd = new PDO('mysql:host=localhost;dbname=wintoz', 'root', '');
session_start();
if(isset($_POST['login'])){
    if(!empty($_POST['user']) AND !empty($_POST['pass'])) {
        $user = htmlspecialchars($_POST['user']);
        $pass = hash('sha512', $_POST['pass']);

        $requser = $bdd->prepare("SELECT * FROM users WHERE user = ? AND pass = ?");
        $requser->execute(array($user, $pass));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $requser = $bdd->prepare("UPDATE users SET ip = ?, date = UNIX_TIMESTAMP() WHERE id = ?");
            $requser->execute(array($_SERVER['REMOTE_ADDR'], $userinfo['id']));
            echo "ok";
        } else {
            echo "Vous n'êtes pas enregistré dans nos bases de données. Veuillez vous inscrire s'il vous plaît.";
        }
    } else {
        echo "Tous les champs doivent être remplis.";
    }
} else { 
    echo "Erreur";
    header ("Location: /");
}
?>