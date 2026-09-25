<?php
require_once __DIR__ . "/mail/sendMail.php";
sendMail("Test User", "test@example.com", "9999999999", "male", "Test message");
echo "Mail attempted — check inbox/spam.";