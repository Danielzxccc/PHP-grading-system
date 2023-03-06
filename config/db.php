<?php
//change your password
$con = mysqli_connect("localhost", "root", "root123", "grading");

if (!$con) {
    die('Connection failed!' . mysqli_connect_error());
}
