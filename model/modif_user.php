<?php
if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

require('model/save_user.php');

function modif_user($pseudo, $email, $newpassword, $actualpassword) {

    require('config/setup.php');
    $req = $db->prepare('select * from users where email=?');
    $req->execute(array($_SESSION['email']));
    $data = $req->fetch();

    if (isset($data['password']) && password_verify($actualpassword, $data['password']) == true) {

        if (check_login($pseudo) == 0)
        {
            ?>
            <script type='text/javascript'>
                alert('Le login est déjà prit.\n');
            </script>
            <?php
            return(0);
        }
        else if (check_email($email) == 0)
        {
            ?>
            <script type='text/javascript'>
                alert('L\'email est déjà prit.\n');
            </script>
            <?php
            return(0);
        }
        if ($pseudo != '') {
            $req = $db->prepare('update users set login=? where email=?');
            $req->execute(array($pseudo ,$_SESSION['email']));
            $_SESSION['pseudo'] = $pseudo;
        }
        if ($email != '') {
            $req = $db->prepare('update users set email=? where email=?');
            $req->execute(array($email ,$_SESSION['email']));
            $_SESSION['pseudo'] = $email;
        }
        if ($newpassword != '') {
            $pass_hash = password_hash($newpassword, PASSWORD_DEFAULT);
            $req = $db->prepare('update users set password=? where email=?');
            $req->execute(array($pass_hash ,$_SESSION['email']));
            $_SESSION['pass'] = $pass_hash;
        }
        return(1);
    }
    else {
        ?>
        <script type='text/javascript'>
            alert('Mauvais mot de passe.\n');
        </script>
        <?php
        return(0);
    }

}