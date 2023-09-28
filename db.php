<?php


//define(__ROOT__ ,'/interview_task/controller/registerdata.php');
define ('__ROOT__', '/interview_task/controller/registerdata.php');

$database = 'interview_task';
$host = 'localhost';
$username = 'root';
$password = '';

try {

$db = new PDO("mysql:host=$host;dbname=$database;charset=UTF8", $username, $password);
if($db){
   // echo "database connected";
}
} catch (\Throwable $th) {
   echo $th->getMessage();
}




?>