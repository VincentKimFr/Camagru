<?php
if (session_status() != PHP_SESSION_ACTIVE)
    session_start();

function save_img($img)
{
    require('config/setup.php');

    $req = $db->prepare('select * from users where email=?');
    $req->execute(array($_SESSION['email']));
    $data = $req->fetch();
    $data = $data['user_id'];

    $inserer = $db->prepare('insert into pictures (uri, pub_date, author_id)
            values (:uri, NOW(), :author_id)');
    $inserer->execute(array(
        'uri' => $img,
        'author_id' => $data
    ));
    return(1);
}