<?php
require_once '../config/db.php';
$headertitle = 'RECORDS'
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
</head>

<body>
    <?php include_once('../includes/header.php') ?>

    <main class="d-block d-md-flex full-height container-background">
        <!--  -->
        <div class="col p-3">
            <div class="d-flex justify-content-center align-items-center">
                <input type="text" name="studentname" id="studentname" class="form-control border border-dark m-input mx-2 " readonly>
                <button class="btn border border-dark" data-bs-toggle="modal" data-bs-target="#studentModal">SELECT</button>
            </div>
            <div class="mt-5 mx-3">
                <h5 class="fw-bold ms-2">STUDENT FOR ADD SUBJECTS</h5>
                <div class="bg-white">
                    <div class="container py-4">
                        <div class="row mb-3">
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
                    </div>
                </div>
                <!-- add button -->
                <div class="d-flex justify-content-end mx-4 mt-3">
                    <button class="btn btn-primary text-white" id="btnAddSubject">ADD SUBJECT</button>
                </div>
            </div>
        </div>
        <!-- PRINTABLES -->
        <div class="col ">test</div>
    </main>

    <!-- MODALS HERE -->
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

</body>

</html>