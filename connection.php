<?php
$servername="localhost";
$username="root";
$password="";
$db_name="shop_db";

$conn= mysqli_connect($servername, $username,$password, $db_name);
if(!$conn) 
die("Lipseste conectiunea:".mysqli_connect_error());
?>