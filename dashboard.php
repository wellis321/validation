<?php
// Dashboard has been removed - redirect to homepage
// Client-side processing means we don't track metrics,
// so the dashboard was redundant with the homepage
header('Location: /');
exit;
?>
