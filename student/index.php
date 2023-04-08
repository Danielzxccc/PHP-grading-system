<?php
session_start();
require_once '../config/db.php';

$stmt = $con->prepare("SELECT * FROM students WHERE userid = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/professor/main.js" defer></script>
    <script src="../js/bootstrap.bundle.js" defer></script>
    <script src="../js/sweetalert.js"></script>
    <script src="../js/student/main.js" defer></script>
</head>

<body>
    <?php include '../includes/student-header.php' ?>
    <main class="container">
        <div class="overflow-auto bg-white">
            <form id="submitFilter">
                <div class="d-flex align-items-center py-4">
                    <div class="mx-1">
                        <label for="school_year" class="form-label">--School Year--</label>
                        <select name="schoolyear" id="schoolyear" class="form-select" required>
                            <option value="2022-2023">2022-2023</option>
                            <option value="2024-2025">2024-2025</option>
                        </select>
                    </div>
                    <div class="mx-1">
                        <label for="school_semester" class="form-label">--Semester--</label>
                        <select name="semester" id="semester" class="form-select" required>
                            <option value="1">First Semester</option>
                            <option value="2">Second Semester</option>
                        </select>
                    </div>
                    <button class="btn border border-dark ms-4 align-self-end">Display</button>
                </div>
            </form>
            <table class="table table-striped text-center table-bordered">
                <thead class="bg-dark text-white">
                    <th>COURSE CODE</th>
                    <th>SUBJECT</th>
                    <th>UNITS</th>
                    <th>GRADE</th>
                    <th>FACULTY</th>
                </thead>
                <tbody id="getStudentGrades">

                </tbody>
            </table>
        </div>
    </main>
</body>

</html>