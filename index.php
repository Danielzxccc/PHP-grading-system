<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/index.css">
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap.bundle.js" defer></script>
    <script src="./js/sweetalert.js"></script>
</head>

<body>
    <main>
        <div class="row justify-content-center align-items-center vh-100 login-form">
            <div class="login-background vh-100 col d-none d-md-block">

            </div>
            <div class="d-flex justify-content-center align-items-center flex-column col">
                <div class="d-flex justify-content-center align-items-center flex-column mb-5">
                    <img src="./assets/school_logo.png" alt="school_logo">
                    <h4 class="text-center text-primary fw-bold">ONLINE STUDENT ACADEMIC <br> RECORD AND GRADING SYSTEM</h4>
                </div>
                <!-- login form -->
                <div>
                    <form id="loginForm">
                        <div class="row align-items-center mb-3">
                            <div class="col-4 text-center">
                                <label for="username" class="form-label">Username:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control border border-dark">
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-4 text-center">
                                <label for="username" class="form-label me-2">Password:</label>
                            </div>
                            <div class="col-8">
                                <input type="password" class="form-control border border-dark">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-warning w-50">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault()
            Swal.fire(
                'RAWR',
                'HALIKA',
                'success'
            )
        })
    </script>
</body>

</html>