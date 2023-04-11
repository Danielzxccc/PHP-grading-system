<?php
session_start();
require_once '../config/db.php';
$headertitle = 'RECORDS';


if ($_SESSION['role'] !== "admin") {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/jquery.js"></script>
    <script src="../js/admin/main.js" defer></script>
    <script src="../js/bootstrap.bundle.js" defer></script>
    <script src="../js/sweetalert.js"></script>
    <script src="../js/printThis.js"></script>
</head>

<body class="container-background">
    <?php include_once('../includes/header.php') ?>

    <main class="d-block d-md-flex full-height">
        <!--  -->
        <div class="p-3 w-100 w-md-50">
            <div class="d-flex justify-content-center align-items-center">
                <input type="text" name="studentname" id="studentname" class="form-control border border-dark m-input mx-2 " readonly>
                <button class="btn border border-dark" data-bs-toggle="modal" data-bs-target="#studentModal">SELECT</button>
            </div>
            <div class="mt-2 mx-3">
                <h5 class="fw-bold ms-2">STUDENT FOR ADD SUBJECTS</h5>
                <div class="bg-white flex-none">
                    <div class="container py-4">
                        <div class="row mb-3">
                            <input type="hidden" id="studentid">
                            <div class="col-4 text-end fw-semibold">NAME:</div>
                            <div class="col-8 studentname"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-end fw-semibold">COURSE:</div>
                            <div class="col-8 studentcourse"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-end fw-semibold">YEAR LEVEL :</div>
                            <div class="col-8">
                                <div class="d-flex align-items-center">
                                    <span class="me-5 studentyear">1st Year</span>
                                    <span class="me-2">STUDENT #</span>
                                    <span class="studentid"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-4 text-end fw-semibold">ADD SUBJECT:</div>
                            <div class="col-8">
                                <select name="subject" id="subject" class="form-select w-75">
                                    <option value="">SELECT SUBJECT</option>
                                    <?php
                                    // query subjects course code
                                    $stmt = $con->prepare("SELECT * FROM subjects");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['coursecode'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-4 text-end fw-semibold">DESCRIPTION:</div>
                            <div class="col-6 coursedescription border ms-2 py-2">...</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4 text-end fw-semibold">UNITS:</div>
                            <div class="col-8 subjectunit"></div>
                        </div>
                    </div>
                </div>
                <!-- add button -->
                <div class="d-flex justify-content-end mx-4 mt-3">
                    <button class="btn btn-primary text-white" id="btnAddSubject">ADD SUBJECT</button>
                </div>
                <!-- subjects table -->

            </div>
        </div>
        <!-- PRINTABLES -->
        <div class="w-100 w-md-50 mt-5" id="printGrade">
            <button href="#" class="btn btn-success ms-2" id="acceptStudentButton">Accept Incoming Students</button>
            <div class="bg-white mt-2 student-subject-table mt-2">
                <table class="table text-center" align="center">
                    <thead class="py-2 table-head">
                        <th class="d-print-none"></th>
                        <th class="py-2">NAME</th>
                        <th class="py-2">COURSE</th>
                        <th class="py-2">YEAR LEVEL</th>
                        <th class="py-2">STUDENT #</th>
                        <th class="py-2">COURSE CODE</th>
                        <th class="py-2">DESCRIPTION</th>
                        <th class="py-2">UNITS</th>
                    </thead>
                    <tbody id="studentSubjectList">
                    </tbody>
                </table>
            </div>
            <div class="my-3">
                <div class="d-flex justify-content-end">
                    <button class="mx-1 btn btn-success btnUpdate d-print-none">UPDATE</button>
                    <button class="mx-1 btn btn-danger btnDelete d-print-none">DELETE</button>
                    <button class="mx-1 btn btn-info btnPrint d-print-none">PRINT</button>
                </div>
            </div>
        </div>
    </main>
    <div class="mx-3 my-4">
        <h5 class="fw-bold ms-2">LIST OF STUDENT'S GRADES</h5>
        <div>
            <div class="overflow-auto bg-white">
                <table class="table text-center table-bordered">
                    <thead>
                        <th>SUBJECT</th>
                        <th>FIRST MONTHLY</th>
                        <th>FIRST PRELIM</th>
                        <th>SECOND PRELIM</th>
                        <th>MIDTERM</th>
                        <th>PRE FINAL</th>
                        <th>FINAL</th>
                        <th>AVERAGE</th>
                        <th>REMARK</th>
                        <th>STATUS</th>
                        <th>COURSE</th>
                        <th>SECTION</th>
                    </thead>
                    <tbody id="getStudentGrades">

                    </tbody>
                </table>
            </div>
            <div class="my-4">
                <button class="btn btn-primary d-none" id="releaseGrades">Release Grades</button>
            </div>
        </div>
    </div>

    <!-- MODALS HERE -->
    <!-- SELECT STUDENT -->
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

    <!-- UPDATE SUBJECT -->
    <div class="modal fade" id="updateSubject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Subject</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateSubjectForm">
                    <div class="modal-body">
                        <select name="selectsubject" id="selectsubject" class="form-select w-75" required>
                            <option value="">SELECT SUBJECT</option>
                            <?php
                            // query subjects course code
                            $stmt = $con->prepare("SELECT * FROM subjects");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['id'] ?>"><?php echo $row['coursecode'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <div class="updatedescription my-2"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="acceptStudents" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Accepts Students</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-dark text-white">
                                <th>Student ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>Contact #</th>
                                <th>Age</th>
                                <th>Birthdate</th>
                                <th>Sex</th>
                                <th>Type of Scholarship</th>
                                <th>Course</th>
                                <th>Year Level</th>
                                <th>Actions</th>
                            </thead>
                            <tbody id="incomingStudents">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>