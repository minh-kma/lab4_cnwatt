<?php
defined('IN_ADMIN') or exit('Forbidden');

unset($_SESSION['Username'], $_SESSION['LoginTime']);
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

header('Location: ../session.php');
exit;
