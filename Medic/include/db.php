<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "lhs_clinic";

$conn = new mysqli($host, $user, $pass, $db);
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
