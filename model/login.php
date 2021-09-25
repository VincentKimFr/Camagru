<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();

function login_model($email, $pass) {

	require('config/setup.php');

	$req = $db->prepare('select * from users where email=?');
	$req->execute(array($email));
	$data = $req->fetch();

	if (isset($data['password']) && password_verify($pass, $data['password']) == true
		&& isset($data['confirmed']) && $data['confirmed'] == 1) {
		$_SESSION['login'] = 1;
		$_SESSION['pseudo'] = $data['login'];
		$_SESSION['email'] = $data['email'];
		$_SESSION['pass'] = $data['password'];
		return (1);
	} else if (isset($data['confirmed']) && $data['confirmed'] == 0) {
		require('model/mail.php');
		send_mail($data['email'], $data['login']);
		confirm_register();
		return (2);
	} else {
		return (0);
	}
}