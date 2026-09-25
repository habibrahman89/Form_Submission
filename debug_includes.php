<?php
ini_set('display_errors',1); error_reporting(E_ALL);
ob_start();
include 'db.php';
include 'mail/sendMail.php';
$out = ob_get_clean();
header('Content-Type: text/plain');
echo "INCLUDE OUTPUT:\n";
echo $out;