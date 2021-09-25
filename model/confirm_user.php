<?php

function confirm_account($token)
{
	require('config/setup.php');

	$req = $db->prepare('SELECT * FROM users WHERE user_id = ? AND confirmed=false');
	$req->execute(array($token));

	if ($req->rowCount() == 1)
	{
		$req = $db->prepare('update users set confirmed=true where user_id=?');
		$req->execute(array($token));
		return(1);

	}
	else
		return(0);
}