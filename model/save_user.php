<?php

function register_user($pseudo, $email, $password)
{
	$err = "";

	require('config/setup.php');

	if (check_login($pseudo) == 0)
	{
		$err = 'Le login est déjà prit' . PHP_EOL;
		return($err);
	}
	else if (check_email($email) == 0)
	{
		$err = 'L\'email est déjà prit' . PHP_EOL;
		return($err);
	}
	$pass_hash = password_hash($password, PASSWORD_DEFAULT);
	$inserer = $db->prepare('insert into users (login, email, password, confirmed)
			values (:login, :email, :password, false)');
	$inserer->execute(array(
		'login' => $pseudo,
		'email' => $email,
		'password' => $pass_hash
	));
	return(1);
}

function check_login($pseudo)
{
	require('config/setup.php');

	$req = $db->prepare('select * from users where login= ?');
	$req->execute(array($pseudo));
	$data = $req->fetch();
	
	if ($data != 0)
		return 0;
	else
		return 1;
}

function check_email($email)
{
	require('config/setup.php');

	$req = $db->prepare('select * from users where email= ?');
	$req->execute(array($email));
	$data = $req->fetch();
	
	if ($data != 0)
		return 0;
	else
		return 1;
}