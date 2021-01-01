<?php
$dsn = 'mysql:host=localhost;dbname=practice';
$username = 'root';
$password = 'rootroot';
$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
); 

$pdo = new PDO($dsn, $username, $password, $options);
?>