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

    if (isset($_POST['addStudentGrade'])) {
        $stmt = $con->prepare("INSERT INTO `studentgrade`
        (`studentsubjectid`, `monthly`, `firstprelim`, `secondpremlim`, `midterm`, 
        `prefinal`, `final`, `schoolyear`, `semester`, `section`, `graderemark`, `profid`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssssssssi",
            $_POST['studentsubjectid'],
            $_POST['monthly'],
            $_POST['firstprelim'],
            $_POST['secondpremlim'],
            $_POST['midterm'],
            $_POST['prefinal'],
            $_POST['final'],
            $_POST['schoolyear'],
            $_POST['semester'],
            $_POST['section'],
            $_POST['graderemark'],
            $_SESSION['id']
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
            message(true, 'Added Successfully');
        } else {
            echo $stmt->error;
            message(false, $stmt->error);
        }
    }
}
