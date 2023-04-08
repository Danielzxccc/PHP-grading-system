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

    if (isset($_POST['editStudentGrade'])) {
        $stmt = $con->prepare("UPDATE studentgrade SET 
        monthly = ?,
        firstprelim = ?,
        secondpremlim = ?,
        midterm = ?,
        prefinal = ?,
        final = ?,
        semester = ?,
        section = ?,
        graderemark = ? 
        WHERE id = ?");

        $stmt->bind_param(
            "ddddddddsi",
            $_POST['__monthly'],
            $_POST['__firstprelim'],
            $_POST['__secondpremlim'],
            $_POST['__midterm'],
            $_POST['__prefinal'],
            $_POST['__final'],
            $_POST['__semester'],
            $_POST['__section'],
            $_POST['__graderemark'],
            $_POST['id'],
        );

        try {
            $stmt->execute();
        } catch (Exception $e) {
            if ($e->getCode() == 1062) {
                // This error code indicates a duplicate entry error
                message(false, "This subject is already graded.");
            } else {
                message(false, $e->getMessage());
            }
        }


        if ($stmt->affected_rows > 0) {
            message(true, 'Updated Successfully');
        } else {
            echo $stmt->error;
            message(false, $stmt->error);
        }
        exit();
    }

    if (isset($_POST['deleteStudentGrade'])) {
        $stmt = $con->prepare("DELETE FROM studentgrade WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            message(false, $e->getMessage());
        }

        if ($stmt->affected_rows > 0) {
            message(true, 'Deleted Successfully');
        } else {
            echo $stmt->error;
            message(false, $stmt->error);
        }
        exit();
    }
}
