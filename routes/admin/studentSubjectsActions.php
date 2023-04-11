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

    if (isset($_POST['releaseGrades'])) {
        $id =  $_POST['id'];
        $stmt = $con->prepare("UPDATE studentgrade
        JOIN studentsubjects ON studentsubjects.id = studentgrade.studentsubjectid
        JOIN subjects ON studentsubjects.subjectid = subjects.id
        JOIN students ON studentsubjects.studentid = students.id
        SET studentgrade.status = 1
        WHERE studentsubjects.studentid = ? AND studentgrade.id > 0");
        $stmt->bind_param("i", $id);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            message(false, $e->getMessage());
        }

        message(true, 'Released Successfully');
    }

    if (isset($_POST['acceptStudent'])) {
        $id =  $_POST['id'];
        $stmt = $con->prepare("UPDATE users SET isApproved = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            message(false, $e->getMessage());
        }

        message(true, 'Released Successfully');
    }
}
