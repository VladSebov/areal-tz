<?php

$MYSQL_ROOT_PASSWORD = getenv('MYSQL_ROOT_PASSWORD');
$MYSQL_DATABASE = getenv('MYSQL_DATABASE');

$conn = mysqli_connect("mysql", "root", $MYSQL_ROOT_PASSWORD, $MYSQL_DATABASE);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "SET NAMES utf8mb4");
mysqli_query($conn, "SET CHARACTER SET utf8mb4");
mysqli_query($conn, "SET collation_connection = utf8mb4_unicode_ci");
?>