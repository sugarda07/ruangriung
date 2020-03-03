<?php

$DB_host = "localhost";
//$DB_user = "root";
$DB_user = "smkikaka_ruangriung";
//$DB_pass = "";
$DB_pass = "123ruangriung456";
//$DB_name = "ruangdigital";
$DB_name = "smkikaka_ruangriung"; 
$message = "";

	try  
	{  
		$connect = new PDO("mysql:host={$DB_host};dbname={$DB_name};charset=utf8mb4",$DB_user,$DB_pass);  
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
	}  
	catch(PDOException $error)  
	{  
		$message = $error->getMessage();  
	}  

?>