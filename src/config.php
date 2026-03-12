<?php

$MYSQL_ROOT_PASSWORD = getenv('MYSQL_ROOT_PASSWORD');
$MYSQL_DATABASE = getenv('MYSQL_DATABASE');

$conn = mysqli_connect("mysql", "root", $MYSQL_ROOT_PASSWORD, $MYSQL_DATABASE);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}