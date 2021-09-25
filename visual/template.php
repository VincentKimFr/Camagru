<?php
    if (session_status() != PHP_SESSION_ACTIVE)
        session_start();
    if (!isset($_SESSION['login'])) {
        $_SESSION['login'] = 0;
    }
    if (!isset($_SESSION['pseudo'])) {
        $_SESSION['pseudo'] = '';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title><?= $title ?></title>
        <link rel='stylesheet' href='public/style/style.css'>
    </head>
    <body>
<?php
require('visual/header.php');
require($content);
require('visual/footer.html');
?>
    </body>
</html>