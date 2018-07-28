<?php
//header('Content-Type: text/html; charset=utf-8');
// ------------------------------------
// html/config.php
// ------------------------------------
/*
DROP DATABASE IF EXISTS `missedclass`;
CREATE DATABASE `missedclass`;
use `missedclass`;
-- --------------------------------------------------------
-- user is `missedclass`
-- password is missedclass123
GRANT ALL PRIVILEGES ON missedclass.* TO missedclass@localhost IDENTIFIED BY 'missedclass123';

*/
$servername = 'localhost';
$username = 'missedclass';
$password = 'missedclass123';
$dbname = 'missedclass';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn,"utf8");




