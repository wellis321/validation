<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/Model.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/includes/Auth.php';

$auth = Auth::getInstance();
$auth->logout();

header('Location: /login.php');
exit;
