<?php
/**
 * DB Configuration
 */
define('DB_HOST',			'localhost');
define('DB_USER',			'root');
define('DB_PASS',			'');
define('DB_NAME',			'flower_shop');
# db connect
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to MySQL DB ') . mysqli_error();
$db = mysqli_select_db($link, DB_NAME); 
$tbl_name="flowers";
?>
