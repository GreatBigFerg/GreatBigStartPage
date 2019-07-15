<?php
// Set TimeZone //
ini_set('date.timezone', 'America/New_York');
error_reporting(E_ALL);// Display errors //
ini_set('display_errors', 1);// Display errors //

// Database credentials //
define('DB_SERVER', 'localhost');
define('DB_USER', 'dev-user');
define('DB_PASS', '@Dev6969');
define('DB_NAME', 'jre-wiki');

$from_email = "noreply@tenmore.solutions";
$reply_email = "noreply@tenmore.solutions";
$admin_email = "bryce@tenmore.solutions";

$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9._%-]+.[A-Za-z0-9._%-]+$/';
$phone_exp = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})+$/';
$string_exp = "/^[A-Za-z .'-]+$/";

