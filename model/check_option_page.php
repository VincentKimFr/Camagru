<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();

function check_auth()
{
	

	if (isset($_SESSION['email']) && isset($_SESSION['pseudo']) && isset($_SESSION['pass']) && isset($_SESSION['login']) && $_SESSION['login'] == 1)
	{
		require('config/setup.php');
		$req = $db->prepare('select * from users where email=?');
		$req->execute(array($_SESSION['email']));
		$data = $req->fetch();

		if (isset($data['password']) && $_SESSION['pass'] == $data['password']
			&& isset($data['email']) && $data['email'] == $_SESSION['email']
			&& isset($data['login']) && $data['login'] == $_SESSION['pseudo']
			&& isset($data['confirmed']) && $data['confirmed'] == 1) {
			return (1);
		} else {
			return (0);
		}
	}
	else
		return (0);
}