<?php 

define('host',$_SERVER['DB_HOST']);
define('user',$_SERVER['DB_USER']);
define('pass',$_SERVER['DB_USER_PASSWORD']);
define('db_name',$_SERVER['DB_SCHEMA']);

$con=mysqli_connect(host,user,pass,db_name);

if(!$con){
	die("failed to connect to database");
}

?>
