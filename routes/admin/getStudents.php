<?php
session_start();

require_once '../../config/db.php';



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
    //fetch student based on parameters
    if (isset($_POST['getAllStudents'])) {
        $searchParam = "%" . $_POST['search'] . "%";
        $stmt = $con->prepare("SELECT * 
        FROM students 
            WHERE lastname LIKE ? 
            OR firstname LIKE ?
            OR middlename LIKE ?
            OR id LIKE ?
            OR studentid LIKE ?
            OR course LIKE ?
        LIMIT 10");
        $stmt->bind_param(
            "sssiss",
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $output = '';
        while ($row = $result->fetch_assoc()) :
            $output .= "
        <tr>
            <td><input name='student' type='radio' class='student-radio' value='" . $row['id'] . "' /></td>
            <td>" . $row['studentid'] . "</td>
            <td>" . $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename'] . ".</td>
            <td>" . $row['course'] . "</td>
        </tr>
        ";
        endwhile;
        echo $output;
        exit();
    }
    //fetch single student info
    if (isset($_POST['getStudentInfo'])) {
        $stmt = $con->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        exit();
    }

    if (isset($_POST['getSubjectInfo'])) {
        $stmt = $con->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        exit();
    }
}
