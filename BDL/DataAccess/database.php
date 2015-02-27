<?php 
//populate all the connection info and authentication
$dsn = 'mysql:host=localhost;dbname=WindyCityStriders';
$username = 'root';
$password = '5713mood';
try{
//create the PhpDataObject
$db= new PDO($dsn,$username,$password);
}
catch(PDOException $ex)
{
$errorMessage = 'Database exception ' . $ex->getMessage();
include('errorPage.php');
exit();
}
?>
