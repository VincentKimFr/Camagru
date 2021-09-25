<?php

function forgetPasswordAction($email)
{
    require('config/setup.php');
    $req = $db->prepare('select * from users where email=?');
    $req->execute(array($email));

    if ($req->rowCount() == 1) {

        $new_passwd = bin2hex(random_bytes(5));
        $pass_hash = password_hash($new_passwd, PASSWORD_DEFAULT);
        $data = $req->fetch();
        $req = $db->prepare('update users set password=? where email=?');
        $req->execute(array($pass_hash, $email));
        require('model/mail.php');
        return(send_newpassword_mail($email, $new_passwd));
    }
    else {
        return(-1);
    }
}