		<header>
			<div><h1>Camagru</h1><br></div>
			<div><a href='index.php'>Acceuil</a><br></div>
<?php
	if (isset($_SESSION['login']) && $_SESSION['login'] == 1)
	{
?>
			<div>Bienvenue <?php echo htmlspecialchars($_SESSION['pseudo']); ?><br> </div>
			<div><a href='index.php?page=webcam'>Webcam</a><br></div>
			<div><a href='index.php?page=galery'>Gallerie</a><br></div>
			<div><a href='index.php?page=user_options'>Options d'utilisateur</a><br></div>
			<div><a href='index.php?control=account&action=disconect'>Deconnecter</a><br></div>
<?php
	}
	else
	{
?>
			<div><a href='index.php?page=register_page'>Créer un compte</a><br></div>
			<div><a href='index.php?page=login_page'>Connexion</a><br></div>
			<div><a href='index.php?page=galery'>Gallerie</a><br></div>
<?php
	}
?>
			<hr>
		</header>
