<?php
if (session_status() != PHP_SESSION_ACTIVE)
	session_start();

require('model/check_option_page.php');
require('model/img_author.php');

function home()
{
	$title = 'Camagru - Acceuil';
	$content =  'visual/home.html';
	require('visual/template.php');
}

function register_page()
{
	$title = 'Camagru - Créer un compte';
	$content =  'visual/register.html';
	require('visual/template.php');
}

function login_page()
{
	$title = 'Camagru - Se connecter';
	$content =  'visual/login.html';
	require('visual/template.php');
}

function forgetpassword_page()
{
	$title = 'Camagru - Mot de passe oublié';
	$content =  'visual/forgetpassword.html';
	require('visual/template.php');
}

function options_page()
{
	$ret = check_auth();
	if ($ret == 1) {
		$title = 'Camagru - Options';
		$content =  'visual/options.html';
		require('visual/template.php');
	}
	else
		home();
}

function webcam_page()
{
	$ret = check_auth();
	if ($ret == 1) {
		$title = 'Camagru - Webcam';
		$content =  'visual/webcam.php';
		require('visual/template.php');
	}
	else
		home();
}

function confirm_register()
{
	$title = 'Camagru - confirmation de compte';
	$content =  'visual/need_confirm_email.html';
	require('visual/template.php');
}

function error_confirm_account()
{
	$title = 'Camagru - confirmation de compte';
	$content =  'visual/error_confirm.html';
	require('visual/template.php');
}

function confirm_account_visual()
{
	$title = 'Camagru - confirmation de compte';
	$content =  'visual/confirm_success.html';
	require('visual/template.php');
}

function register_action()
{
	$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	$confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';

	$err = "";

	if (count($_POST) != 4 || $pseudo == '' || $email == '' || $password == '' || $password != $confirmpassword
		|| !preg_match('#^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^a-zA-Z0-9\s]).{8,}$#', $password)
		|| !preg_match('#[^@]+@.+\..+#', $email))
	{
		register_page();
	}
	else
	{
		require('model/save_user.php');

		$err = register_user($pseudo, $email, $password);

		if ($err != 1)
		{
			if ($err == 'Le login est déjà prit' . PHP_EOL)
			{
				?>
				<script type='text/javascript'>
					alert('Le login est déjà prit\n');
				</script>
				<?php
			}
			else
			{
				?>
				<script type='text/javascript'>
					alert('L\'email est déjà prit\n');
				</script>
				<?php
			}
			register_page();
		}
		else
		{
			require('model/mail.php');
			$ret = send_confirm_mail($email, $pseudo);
			if ($ret == 1)
				confirm_register();
			else
			{
				?>
				<script type='text/javascript'>
					alert('Echec d\'envoie d\'email\n');
				</script>
				<?php
				register_page();
			}
		}
	}
}

function modif_account_options()
{
	$pseudo = isset($_POST['newpseudo']) ? $_POST['newpseudo'] : '';
	$email = isset($_POST['newemail']) ? $_POST['newemail'] : '';
	$newpassword = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';
	$confirmnewpassword = isset($_POST['confirmnewpassword']) ? $_POST['confirmnewpassword'] : '';
	$actualpassword = isset($_POST['actualpassword']) ? $_POST['actualpassword'] : '';

	if (count($_POST) > 1 && count($_POST) < 6 && $actualpassword != ''
		&& ($pseudo != ''
			|| ($email != '' && preg_match('#[^@]+@.+\..+#', $email))
		|| ($newpassword != '' && $newpassword == $confirmnewpassword)))
	{
		$ret = check_auth();
		if ($ret == 1)
		{
			require('model/modif_user.php');
			$ret2 = modif_user($pseudo, $email, $newpassword, $actualpassword);
			if ($ret2 == 0) {
				options_page();
			}
			else {
				?>
	            <script type='text/javascript'>
	                alert('Changements effectués avec succes.\n');
	            </script>
	            <?php
				options_page();
			}
		}
		else {
			home();
		}
	}
	else {
		home();
	}
}

function confirm_account_action()
{
	$token = isset($_GET['token']) ? $_GET['token'] : '';

	if (count($_GET) != 3 || $token == '')
	{
		error_confirm_account();
	}
	else
	{
		require('model/confirm_user.php');
		$ret = confirm_account($token);
		if ($ret == 1)
			confirm_account_visual();
		else
		{
			?>
			<script type='text/javascript'>
				alert('Le compte n\'a pas pu être confirmé.\n');
			</script>
			<?php
			error_confirm_account();
		}
	}
}

function login_action()
{
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';

	if (count($_POST) == 2 && $email != '' && $password != '')
	{
		require('model/login.php');
		$ret = login_model($email, $password);
		if ($ret == 1) {
			home();
		} else if ($ret == 2)
		{
			?>
			<script type='text/javascript'>
				alert('Compte non confirmé, e-mail renvoyé.\n');
			</script>
			<?php
		}
		else {
			?>
			<script type='text/javascript'>
				alert('Mot de passe ou identifiant incorrect.\n');
			</script>
			<?php
			login_page();
		}
	}
	else {
		login_page();
	}
}

function forgetpassword() {

	$email = isset($_POST['email']) ? $_POST['email'] : '';

	if (count($_POST) == 1 && $email != '') {
		require('model/forget_password.php');
		$ret = forgetPasswordAction($email);
		if ($ret == 1) {
			?>
			<script type='text/javascript'>
				alert('Mail de récupération de mot de passe envoyé.');
			</script>
			<?php
			home();
		}
		else if ($ret == 0)
		{
			?>
			<script type='text/javascript'>
				alert('Le mail de récupération de mot de passe n\'a pas pu être envoyé.');
			</script>
			<?php
			home();
		}
		else if ($ret == -1)
		{
			?>
			<script type='text/javascript'>
				alert('Mail introuvable dans notre base de données.');
			</script>
			<?php
			home();
		}
	} else {
		forgetpassword_page();
	}
}

function disconect_action()
{
	$_SESSION['login'] = 0;
	$_SESSION['pseudo'] = '';
	home();
}

function uploadGallery()
{
	$photo = isset($_POST['img'])?$_POST['img']:'';
	$ret = check_auth();
	if ($ret == 1 && substr($photo, 0, strlen('data:image/png;base64')) == 'data:image/png;base64') {
		require('model/save_img.php');
		save_img($photo);
		webcam_page();
	} else {
		home();
	}
}

function authorImg()
{
	$ret = check_auth();
	if ($ret == 1) {
		imgAuthor();
	} else {
		home();
	}
}

function delImg()
{
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if (count($_POST) == 1 && $id != '' && ctype_digit($id) == true)
	{
		$ret = check_auth();
		if ($ret == 1) {
			$ret = checkAuthorDelImg($id);
			if ($ret == 1) {
				webcam_page();
			} else {
				home();
			}
		} else {
			home();
		}
	} else {
		home();
	}
}