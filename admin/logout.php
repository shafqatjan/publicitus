<?php
require('../settings/settings.php');
$objSession = new Session(ADMIN_ROLE);

$objSession->destroySession();
?>