<?php

session_start();
require_once '../../config/db.php';

header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function message($status, $message, $role)
    {
        $msg = array(
            "success" => $status,
            "message" => $message,
            "role" => $role
        );
        echo json_encode($msg);
        die();
    }


    if (!isset($_POST['username'])) {
        message(false, 'Username is required');
    }

    if (!isset($_POST['password'])) {
        message(false, 'password is required');
    }

    $username = $_POST['username'];
    $password =  md5($_POST['password']);

    $stmt = $con->prepare('SELECT * from users WHERE username = ?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $rowUserCount = $result->num_rows;
    if ($rowUserCount == 1) {
        $row = $result->fetch_assoc();
        if ($row['role'] == 'student' && $row['isApproved'] == 0) {
            message(false, 'You need to be approved by the admin before you login.', null);
        } else if ($row['username'] === $username && $row['password'] === $password) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            message(true, "Successfully logged In", $row['role']);
        } else {
            message(false, "Username or password is incorrect.", null);
        }
    } else {
        message(false, "Unknown user.", null);
    }
}
