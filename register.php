<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap.bundle.js" defer></script>
    <script src="./js/sweetalert.js"></script>
</head>

<body class="container-background">
    <main class="d-flex justify-content-center align-items-center flex-column vh-100">

        <div class="bg-white mw-100 w-75 h-100 rounded my-4 overflow-y-auto">
            <!-- header -->
            <div class="background-dark text-white py-3 text-center rounded-top d-flex align-items-center justify-content-center">
                <img src="./assets/school_logo.png" alt="school_logo" class="school-logo mx-2">
                <h2 class="fw-bold mx-2">SCC STUDENT REGISTRATION</h2>
            </div>

            <!-- main form -->
            <form id="mainform" class="mt-5">
                <!-- login credentials -->
                <div class="d-flex justify-content-center mt-3 flex-md-row flex-column px-2 mb-3">
                    <div class="me-md-2">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="ms-md-2">
                        <label for="confirmpassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3 flex-md-row flex-column px-2 mb-3">
                    <div class="me-md-2">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="middlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" id="middlename">
                    </div>
                    <div class="ms-md-2">
                        <label for="studentid" class="form-label">Student Number</label>
                        <input type="text" class="form-control" name="studentid" id="studentid" required>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3 flex-md-row flex-column px-2 mb-3">
                    <div class="me-md-2">
                        <label for="course" class="form-label">Course</label>
                        <select name="course" id="course" class="form-select">
                            <option value="BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT">BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT</option>
                            <option value="BACHELOR OF ARTS IN POLITICAL SCIENCE">BACHELOR OF ARTS IN POLITICAL SCIENCE</option>
                            <option value="BACHELOR OF ELEMENTARY EDUCATION">BACHELOR OF ELEMENTARY EDUCATION</option>
                            <option value="BACHELOR OF SECONDARY EDUCATION MAJOR IN ENGLISH">BACHELOR OF SECONDARY EDUCATION MAJOR IN ENGLISH</option>
                            <option value="BACHELOR OF SECONDARY EDUCATION MAJOR IN MATH">BACHELOR OF SECONDARY EDUCATION MAJOR IN MATH</option>
                            <option value="BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION">BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION</option>
                            <option value="BACHELOR OF SCIENCE IN COMPUTER SCIENCE">BACHELOR OF SCIENCE IN COMPUTER SCIENCE</option>
                            <option value="BACHELOR OF SCIENCE IN TOURISM MANAGEMENT">BACHELOR OF SCIENCE IN TOURISM MANAGEMENT</option>
                        </select>
                    </div>
                    <div class="mx-md-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" required>
                    </div>
                    <div class="ms-md-2">
                        <label for="number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="number" id="number" pattern='^09\d{9}$' title='Enter a valid PH mobile number' required>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3 flex-md-row flex-column px-2 mb-5">
                    <div class="me-md-2">
                        <label for="age" class="form-label text-end">Age</label>
                        <input type="number" class="form-control" name="age" id="age" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="dateofbirth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="dateofbirth" id="dateofbirth" required>
                    </div>
                    <div class="mx-md-2">
                        <label for="sex" class="form-label">Sex</label>
                        <select name="sex" id="sex" class="form-select w-100">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mx-md-2">
                        <label for="typeofscholarship" class="form-label">Type of Scholarship</label>
                        <select name="typeofscholarship" id="typeofscholarship" class="form-select">
                            <option value="TES-UNIFAST">TES-UNIFAST</option>
                            <option value="TOPET ADALEM SCHOLARSHIP">TOPET ADALEM SCHOLARSHIP</option>
                            <option value="MAHARLIKA SCHOLARSHIP">MAHARLIKA SCHOLARSHIP</option>
                            <option value="CAPIS SCHOLARSHIP">CAPIS SCHOLARSHIP</option>
                            <option value="ATHELETIC SCHOLARSHIP">ATHELETIC SCHOLARSHIP</option>
                            <option value="NONE">NONE</option>
                        </select>
                    </div>
                    <div class="ms-md-2">
                        <label for="yearlevel" class="form-label">Year Level</label>
                        <select name="yearlevel" id="yearlevel" class="form-select">
                            <option value="1">1st year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-5">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </form>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $('#mainform').submit(function(e) {
                e.preventDefault()
                const data = $(this).serializeArray()
                $.ajax({
                    url: "./routes/auth/register.php",
                    method: "post",
                    data: data,
                    success: (res) => {
                        console.log(res)
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Successful Registration',
                                allowOutsideClick: false,
                                focusConfirm: true,
                                allowEscapeKey: false,
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    window.location.href = "./index.php"
                                }
                            })
                        } else {
                            Swal.fire(
                                'Failed',
                                `${res.message}`,
                                'error'
                            )
                        }
                    }
                });
            })


        })
    </script>
</body>

</html>