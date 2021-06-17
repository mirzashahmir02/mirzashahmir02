<?php

$server_name = "localhost";
$user_name = "root";
$password = "";
$dbname = "user_attendance";

$link = mysqli_connect($server_name, $user_name, $password, $dbname);

if(!$link){
    die("Connection failed: " . $link->connect_error); 
};


?>