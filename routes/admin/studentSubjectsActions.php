<?php
session_start();

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

    if (isset($_POST['updateStudentSubject'])) {

        $id =  $_POST['id'];
        $subjectid = $_POST['subjectid'];
        $studentid = $_POST['studentid'];

        $stmt = $con->prepare("UPDATE studentsubjects SET subjectid = ? WHERE id = ? ");
        $stmt->bind_param("ii", $subjectid, $id);

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
            message(true, 'Updated Successfully');
        } else {
            message(false, 'Something Went Wrong');
        }
    }

    if (isset($_POST['deleteStudentSubject'])) {
        $id =  $_POST['id'];
        $stmt = $con->prepare("DELETE FROM studentsubjects WHERE id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            message(true, 'Deleted Successfully');
        } else {
            message(false, 'Something Went Wrong');
        }
    }
}
