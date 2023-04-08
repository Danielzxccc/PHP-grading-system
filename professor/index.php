<?php
session_start();
require_once '../config/db.php';
$headertitle = 'GRADES';

if ($_SESSION['role'] !== "professor") {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/professor/main.js" defer></script>
    <script src="../js/bootstrap.bundle.js" defer></script>
    <script src="../js/sweetalert.js"></script>
</head>

<body class="container-background">
    <?php include_once('../includes/header.php') ?>

    <main class="d-block d-md-flex full-height">
        <div class="p-3 w-100 w-md-50">
            <div class="d-flex justify-content-center align-items-center">
                <input type="text" name="studentname" id="studentname" class="form-control border border-dark m-input mx-2 " readonly>
                <button class="btn border border-dark" data-bs-toggle="modal" data-bs-target="#studentModal">SELECT</button>
            </div>
            <form id="gradeForm">
                <div class="mt-2 mx-3">
                    <h5 class="fw-bold ms-2">STUDENT INFORMATION</h5>
                    <div class="bg-white flex-none">
                        <div class="container">
                            <div class="row align-items-center py-2 mb-2">
                                <input type="hidden" id="studentid">
                                <div class="col text-end">Name</div>
                                <div class="col-5"><input type="text" class="form-control studentname" required readonly></div>
                                <div class="col text-end">Section</div>
                                <div class="col">
                                    <select name="section" id="section" class="form-select">
                                        <option value="0">0</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center py-2 mb-2">
                                <div class="col text-end">COURSE</div>
                                <div class="col-5"><input type="text" class="form-control studentcourse" readonly></div>
                                <div class="col text-end">SEMESTER</div>
                                <div class="col">
                                    <select name="semester" id="semester" class="form-select">
                                        <option value="1">1st Sem</option>
                                        <option value="2">2nd Sem</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="me-1">SCHOOL YEAR</div>
                                <select name="schoolyear" id="schoolyear" class="form-select w-75">
                                    <option value="2022-2023">2022-2023</option>
                                    <option value="2024-2025">2024-2025</option>
                                </select>
                            </div>
                            <div class="row align-items-center py-2 mb-2">
                                <div class="col text-end">COURSE CODE</div>
                                <div class="col">
                                    <select name="studentsubjectid" id="studentsubjectid" class="form-select" required>

                                    </select>
                                </div>
                                <div class="col text-end">DESCRIPTION</div>
                                <div class="col-5">
                                    <input type="text" class="form-control" id="coursedescription" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">GRADES</h5>
                    <div class="bg-white">
                        <div class="p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 px-2">
                                    <label for="monthly" class="form-label">FIRST MONTHLY</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="monthly" id="monthly" required step="0.01">
                                    <label for="firstprelim" class="form-label">FIRST PRELIM</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="firstprelim" id="firstprelim" required step="0.01">
                                    <label for="secondpremlim" class="form-label">SECOND PRELIM</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="secondpremlim" id="secondpremlim" required step="0.01">
                                </div>
                                <div class="flex-grow-1 px-2">
                                    <label for="midterm" class="form-label">MIDTERM</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="midterm" id="midterm" required step="0.01">
                                    <label for="prefinal" class="form-label">PRE_FINAL</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="prefinal" id="prefinal" required step="0.01">
                                    <label for="final" class="form-label">FINAL</label>
                                    <input type="number" class="form-control grades" min="50" max="100" name="final" id="final" required step="0.01">
                                </div>
                            </div>
                            <div class="px-2">
                                <label for="graderemark">REMARKS</label>
                                <select name="graderemark" id="graderemark" class="form-select">
                                    <option value="">NONE</option>
                                    <option value="INC">INCOMPLETE</option>
                                    <option value="NC">NO CREDIT</option>
                                    <option value="UD">UNOFFICIALLY DROPPED</option>
                                    <option value="OD">OFFICIALLY DROPPED</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </div>
            </form>

        </div>
        <!-- PRINTABLES -->
        <div class="w-100 w-md-50">
            <div class="bg-white p-3 mt-3">
                <table class="table table-bordered">
                    <thead>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Average</th>
                        <th>Grade</th>
                        <th></th>
                    </thead>
                    <tbody id="studentGrades">

                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- modal here -->
    <div class="modal fade" id="studentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">ADD STUDENT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-3">Search</label>
                        <input type="text" class="form-control w-50" name="search" id="searchStudent">
                    </div>
                    <table class="table text-center">
                        <thead>
                            <th></th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Course</th>
                        </thead>
                        <tbody id="studentList">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSelectStudent">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewGradeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h class="modal-title fs-5" id="viewGradeModalLabel">VIEW GRADE</h>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="studentName px-2">
                        <h6 id="_studentViewGradeName"></h6>
                        <h6 id="_studentViewSubject"></h6>
                    </div>
                    <div class="d-flex">
                        <div class="flex-grow-1 px-2">
                            <label for="_monthly" class="form-label">FIRST MONTHLY</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_monthly" id="_monthly" readonly>
                            <label for="_firstprelim" class="form-label">FIRST PRELIM</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_firstprelim" id="_firstprelim" readonly>
                            <label for="_secondpremlim" class="form-label">SECOND PRELIM</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_secondpremlim" id="_secondpremlim" readonly>
                            <label for="_average" class="form-label">AVERAGE</label>
                            <input type="number" class="form-control" id="_average" readonly>
                        </div>
                        <div class="flex-grow-1 px-2">
                            <label for="_midterm" class="form-label">MIDTERM</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_midterm" id="_midterm" readonly>
                            <label for="_prefinal" class="form-label">PRE_FINAL</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_prefinal" id="_prefinal" readonly>
                            <label for="_final" class="form-label">FINAL</label>
                            <input type="number" class="form-control grades" min="50" max="100" name="_final" id="_final" readonly>
                            <label for="_grade" class="form-label">GRADE</label>
                            <input type="text" class="form-control" id="_grade" readonly>
                        </div>
                    </div>
                    <div class="px-2">
                        <label for="_graderemark">REMARKS</label>
                        <input type="text" name="_graderemark" id="_graderemark" class="form-control" readonly />
                        <label for="__semester" class="form-label">SEMESTER</label>
                        <input type="text" name="_semester" id="_semester" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGradeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h class="modal-title fs-5" id="editGradeModalLabel">EDIT GRADE</h>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStudentSubjectForm">
                    <input type="hidden" name="id" id="__id" value="0">
                    <input type="hidden" name="editStudentGrade" id="editStudentGrade" value="0">
                    <div class="modal-body">
                        <div class="studentName px-2">
                            <h6 id="__studentViewGradeName"></h6>
                            <h6 id="__studentViewSubject"></h6>
                        </div>
                        <div class="d-flex">
                            <div class="flex-grow-1 px-2">
                                <label for="__monthly" class="form-label">FIRST MONTHLY</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__monthly" id="__monthly" step="0.01" required>
                                <label for="__firstprelim" class="form-label">FIRST PRELIM</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__firstprelim" id="__firstprelim" step="0.01" required>
                                <label for="__secondpremlim" class="form-label">SECOND PRELIM</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__secondpremlim" id="__secondpremlim" step="0.01" required>
                            </div>
                            <div class="flex-grow-1 px-2">
                                <label for="__midterm" class="form-label">MIDTERM</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__midterm" id="__midterm" step="0.01" required>
                                <label for="__prefinal" class="form-label">PRE_FINAL</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__prefinal" id="__prefinal" step="0.01" required>
                                <label for="__final" class="form-label">FINAL</label>
                                <input type="number" class="form-control grades" min="50" max="100" name="__final" id="__final" step="0.01" required>
                            </div>
                        </div>
                        <div class="px-2">
                            <label for="__graderemark" class="form-label">REMARKS</label>
                            <select name="__graderemark" id="__graderemark" class="form-select">
                                <option value="">NONE</option>
                                <option value="INC">INCOMPLETE</option>
                                <option value="NC">NO CREDIT</option>
                                <option value="UD">UNOFFICIALLY DROPPED</option>
                                <option value="OD">OFFICIALLY DROPPED</option>
                            </select>
                            <label for="__semester" class="form-label">SEMESTER</label>
                            <select name="__semester" id="__semester" class="form-select w-100">
                                <option value="1">1st Sem</option>
                                <option value="2">2nd Sem</option>
                            </select>
                            <label for="__section" class="form-label">SEMESTER</label>
                            <select name="__section" id="__section" class="form-select w-100">
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>