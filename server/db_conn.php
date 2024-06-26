<?php
$servername = "localhost";
$username = "root";
$password = "123";
$db = "onlineshop";

$con = mysqli_connect($servername, $username, $password,$db,3307);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}