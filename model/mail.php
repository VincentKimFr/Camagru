<?php

function send_confirm_mail($email, $pseudo)
{
	require('config/setup.php');

	$req = $db->prepare('select user_id from users where login=?');
	$req->execute(array($pseudo));
	$data = $req->fetch();
	
	$subject = '[Camagru] Confirmez votre compte';
	$message = 'Bonjour ' . htmlspecialchars($pseudo)  . ',\nCliquez ici pour valider votre compte ou copiez ce lien dans votre navigateur : localhost/index.php?control=account&action=confirm&token=' . $data['user_id'];
    
    echo $message;

	return(mail($email, $subject, $message));
}

function send_newpassword_mail($email, $pass)
{
    require('config/setup.php');

    $req = $db->prepare('select * from users where email=?');
    $req->execute(array($email));
    $data = $req->fetch();
    
    $subject = '[Camagru] Nouveau mot de passe';
    $message = 'Bonjour,\nVotre nouveau mot de passe est \"' . $pass . '\".\nChangez le immédiatement pour votre sécurité.';

    echo $message;

    return(mail($email, $subject, $message));
}