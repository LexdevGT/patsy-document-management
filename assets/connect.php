<?php

$hostname = '161.35.13.96';
//$hostname = 'localhost';
$username = 'user_patsydm';
$password = '2qB$7uR!m9XpZaWd';
$db_name  = 'patsy_dm';

$conn = new mysqli($hostname, $username, $password, $db_name);

if($conn->connect_error){
	die("Connection failed: ".$conn->connect_error);
}else{
	//echo "LOGRADO!";
}

?>