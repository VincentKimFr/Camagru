<?php
if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

function imgAuthor() {

    $count = 0;

    require('config/setup.php');

    $req = $db->prepare('select user_id from users where email=?');
    $req->execute(array($_SESSION['email']));
    $id = $req->fetch()[0];

    $req = $db->prepare('select * from pictures where author_id=?');
    $req->execute(array($id));

    while ($data = $req->fetch())
    {
        echo '<div><img id="thumb' . $count . '" src="'. $data['uri'] .'" height="72" width="96" alt="user photo"/></div>' . PHP_EOL;
        echo '<div class="delThumb" id="del' . $data['img_id'] . '">Supprimer la photo (au-dessus)</div>' . PHP_EOL;
        $count++;
    }
}

function checkAuthorDelImg($idImg) {

    require('config/setup.php');

    $req = $db->prepare('select user_id from users where email=?');
    $req->execute(array($_SESSION['email']));
    $idAuth = $req->fetch()[0];

    $req = $db->prepare('select * from pictures where author_id=? and img_id=?');
    $req->execute(array($idAuth, $idImg));
    $data = $req->fetch();

    if ($req->rowCount() == 1) {
        $req = $db->prepare('delete from pictures where img_id=?');
        $req->execute(array($idImg));
        return(1);
    } else {
        return(0);
    }
}