<?php
require_once __DIR__ . '/includes/init.php';

$auth = Auth::getInstance();
$auth->logout();

// Redirect to homepage after logout
header('Location: /');
exit;
