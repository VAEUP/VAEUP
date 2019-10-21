<?php
$bdd = new PDO('mysql:host=localhost;dbname=wintoz', 'root', '');
session_start();
if(isset($_POST['register'])) {
    if(!empty($_POST['user']) AND !empty($_POST['pass']) AND !empty($_POST['pass2']) AND !empty($_POST['mail'])) {
        $pass = hash('sha512', $_POST['pass']);
        $pass2 = hash('sha512', $_POST['pass']);
        $mail = htmlspecialchars($_POST['mail']);
        $user = htmlspecialchars($_POST['user']);

        if($pass == $pass2) {
            $reqmail = $bdd->prepare("SELECT * FROM users WHERE user = ? AND pass = ?");
            $reqmail->execute(array($mail, $pass));
            $mailexist = $reqmail->rowCount();
            if($mailexist == 0) {
                $insertmbr = $bdd->prepare("INSERT INTO users(username, mail, pass, op, ip_reg, ip_log, date_reg, date_log) VALUES (?, ?, ?, 0, ?, ?, UNIX_TIMESTAMP(), UNIX_TIMESTAMP())");
                $insertmbr->execute(array($user, $mail, $pass, $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_ADDR']));

                $requser = $bdd->prepare("SELECT * FROM users WHERE mail = ? AND pass = ?");
                $requser->execute(array($mail, $pass));
                $userexist = $requser->fetch();
                $_SESSION['id'] = $userexist['id'];
                echo "ok";
            } else {
                echo "Vous avez déjà un compte ! Veuillez vous connectez s'il vous plaît.";
            }
        } else {
            echo "Les mots de passe ne se correspondent pas.";
        }
    } else {
        echo "Les champs ne sont pas remplis.";
    }
} else {
    echo "Erreur";
    header ("Location: /");
}
?>
