<header class="background-dark py-1 px-3">
    <div class="d-flex text-white align-items-center justify-content-between px-2">
        <div class="d-flex align-items-center">
            <img src="../assets/school_logo.png" alt="school_logo" class="school-logo-v2 mx-3">
            <h3 class="fw-bold mx-1">SCC STUDENT <?php echo $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename'] ?></h3>
        </div>
        <form action="../logout.php">
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
</header>