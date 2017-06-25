<?php
define("HOST", ""); 
define("USER", ""); 
define("PASSWORD", ""); 
define("DATABASE", ""); 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$mysqli->set_charset("utf8");
?>
