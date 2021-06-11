<?php
define('DB_USER', 'bp5am');
define('DB_PASS', 'bp5ampass');
define('DB_HOST', 'localhost');
define('DB_NAME', 'ecomerce');
$connect = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
or die('Could not connect to the database');
mysqli_set_charset($connect, 'utf8');
?>