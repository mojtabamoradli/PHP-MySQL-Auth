<?php 

    require_once('./functions/config.php');
    require_once('./functions/functions.php');

    session_destroy();

    if(isset($_COOKIE['email']))
    {
        unset($_COOKIE['email']);
        setcookie('email','',time()-86400);
    }
    
    redirect('./');

?>