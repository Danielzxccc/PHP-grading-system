<?php
session_start();
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['getIndividualGrades'])) {

        $query = "SELECT
        studentgrade.*, studentsubjects.subjectid, subjects.coursecode, subjects.description, subjects.units,
        students.firstname, students.lastname, students.middlename, CONCAT(professor.lastname, ', ', professor.firstname) as profname,
        ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) AS average,
        CASE
            WHEN graderemark != '' THEN graderemark
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 96.5 AND 100 THEN '1.00'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 92.5 AND 96.4 THEN '1.25'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 89.5 AND 92.4 THEN '1.50'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 85.5 AND 89.4 THEN '1.75'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 81.5 AND 85.4 THEN '2.00'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) BETWEEN 75.5 AND 81.4 THEN '2.50'
            WHEN ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) >= 74.5 THEN '3.00 (PASSED)'
            ELSE '5.00 (FAILED)'
        END AS grades
        FROM studentgrade
        JOIN studentsubjects ON studentsubjects.id = studentgrade.studentsubjectid
        JOIN subjects ON studentsubjects.subjectid = subjects.id
        JOIN students ON studentsubjects.studentid = students.id
        JOIN professor ON studentgrade.profid = professor.userid
        WHERE students.userid = ? AND studentgrade.status = 1
        ";

        if (isset($_POST['schoolyear']) && isset($_POST['semester'])) {
            $query .= " AND studentgrade.schoolyear = ? AND studentgrade.semester = ?";
        }

        $query .= " GROUP by studentgrade.id";
        $stmt = $con->prepare($query);

        if (isset($_POST['schoolyear']) && isset($_POST['semester'])) {
            $stmt->bind_param("isi", $_SESSION['id'], $_POST['schoolyear'], $_POST['semester']);
        } else {
            $stmt->bind_param("i", $_SESSION['id']);
        }


        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $result = $stmt->get_result();


        if ($result->num_rows <= 0) {
?>
            <tr>
                <td colspan="5">No Records Found</td>
            </tr>
        <?php
            exit();
        }

        while ($row = $result->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo $row['coursecode'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['units'] ?></td>
                <td><?php echo $row['grades'] ?></td>
                <td><?php echo $row['profname'] ?></td>
            </tr>
<?php
        endwhile;
        exit();
    }
}
