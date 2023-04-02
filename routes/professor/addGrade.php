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

        $studentsubjectid = $_POST['studentsubjectid'];
        $monthly = $_POST['monthly'];
        $firstprelim = $_POST['firstprelim'];
        $secondpremlim = $_POST['secondpremlim'];
        $midterm = $_POST['midterm'];
        $prefinal = $_POST['prefinal'];
        $final = $_POST['final'];
        $average = $_POST['average'];
        $grade = $_POST['grade'];
        $semester = $_POST['semester'];
        $section = $_POST['section'];
        $graderemark = $_POST['graderemark'];

        $stmt = $con->prepare("INSERT INTO studentgrade 
        (studentsubjectid, monthly, firstprelim, 
        secondpremlim, midterm, prefinal, final, 
        average, grade, semester, section, graderemark) VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iiiiiiiiiiss",
            $studentsubjectid,
            $monthly,
            $firstprelim,
            $secondpremlim,
            $midterm,
            $prefinal,
            $final,
            $average,
            $grade,
            $semester,
            $section,
            $graderemark
        );
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            message(true, 'Added Successfully');
        } else {
            message(false, 'Something Went Wrong');
        }
    }
}
