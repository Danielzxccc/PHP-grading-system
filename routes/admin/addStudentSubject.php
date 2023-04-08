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

    $studentid = $_POST['studentid'];
    $subjectid = $_POST['subjectid'];

    if (isset($_POST['addStudentSubject'])) {
        $stmt = $con->prepare("INSERT INTO studentsubjects (studentid, subjectid) VALUES (?, ?)");
        $stmt->bind_param("ii", $studentid, $subjectid);

        $checkUniqueSubject = $con->prepare("SELECT * FROM studentsubjects WHERE subjectid = ? and studentid = ?");
        $checkUniqueSubject->bind_param("ii", $subjectid, $studentid);
        $checkUniqueSubject->execute();
        $checkResult = $checkUniqueSubject->get_result()->num_rows;

        if ($checkResult > 0) {
            message(false, 'Subject Already Added');
        } else {
            $stmt->execute();
        }


        if ($stmt->affected_rows > 0) {
            message(true, 'Added Successfully');
        } else {
            message(false, 'Something Went Wrong');
        }
    }
}
