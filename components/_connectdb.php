<?php 
$server = "localhost";
$username = "root";
$password = "";
$db = "smatodo";
$insert_bool = false;
$con = mysqli_connect($server,$username,$password,$db);
if (!$con) {
    die("Connection to this db is failed due to ".mysqli_connect_error());
}
?>