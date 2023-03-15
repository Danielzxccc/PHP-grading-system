<?php

require_once '../../config/db.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    function message($status, $message)
    {
        $msg = array(
            "success" => $status,
            "message" => $message
        );
        echo json_encode($msg);
        die();
    }

    $username = $_POST['username'];
    $password =  $_POST['password'];
    $email = $_POST['email'];
    $confirmpassword = $_POST['confirmpassword'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $studentid = $_POST['studentid'];
    $course = $_POST['course'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $age = $_POST['age'];
    $dateofbirth = $_POST['dateofbirth'];
    $sex = $_POST['sex'];
    $typeofscholarship = $_POST['typeofscholarship'];



    if ($password != $confirmpassword) {
        message(false, "password does not match");
    }
    $pass = md5($_POST['password']);
    //check if username is already in used
    $checkUser = $con->prepare('SELECT * FROM users WHERE username = ?');
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $rowUserCount = $checkUser->get_result()->num_rows;

    if ($rowUserCount > 0) {
        message(false, "Username is already taken.");
    } else {
        //insert user
        $stmt = $con->prepare('INSERT INTO `users` (`username`, `password`, `email`, `role`) VALUES (?, ?, ?, "student")');
        $stmt->bind_param("sss", $username, $pass, $email);
        $stmt->execute();

        $userid = $stmt->insert_id;

        // insert student values
        $student = $con->prepare("INSERT INTO `students` 
        (`userid`, `studentid`, `firstname`, `middlename`, `lastname`, `address`, 
        `number`, `age`, `dateofbirth`, `sex`, `typeofscholarship`, `course`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $student->bind_param(
            "issssssissss",
            $userid,
            $studentid,
            $firstname,
            $middlename,
            $lastname,
            $address,
            $number,
            $age,
            $dateofbirth,
            $sex,
            $typeofscholarship,
            $course
        );
        $student->execute();

        message(true, "I Love you pareh");
    }
}
