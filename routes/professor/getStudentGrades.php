<?php

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['getStudentGrades'])) {
        $stmt = $con->prepare("SELECT
        studentgrade.*, studentsubjects.subjectid, subjects.coursecode, subjects.description, 
        students.firstname, students.lastname, students.middlename,
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
        WHERE studentsubjects.studentid = ?
        GROUP by studentgrade.id
        ");
        $stmt->bind_param("i", $_POST['id']);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo "<tr><td colspan='5' class='text-center'>No Graded subjects</td>";
            die();
        }
        while ($row = $result->fetch_assoc()) :
?>
            <tr>
                <td style="font-size: smaller;" class="text-center"><?php echo $row['lastname'] . ", " .  $row['firstname'] . " "  . $row['middlename']  ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['average'] ?></td>
                <td><?php echo $row['grades'] ?></td>
                <td>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-info btn-small mx-1 btn-view" data-id="<?php echo $row['id'] ?>">VIEW</button>
                        <button class="btn btn-success btn-small mx-1 btn-edit" data-id="<?php echo $row['id'] ?>">EDIT</button>
                        <button class="btn btn-danger btn-small mx-1 btn-delete" data-id="<?php echo $row['id'] ?>">DELETE</button>
                    </div>
                </td>
            </tr>
<?php
        endwhile;
        // exit();
    }

    if (isset($_POST['getOneStudentGrade'])) {
        $stmt = $con->prepare("SELECT
        studentgrade.*, studentsubjects.subjectid, subjects.coursecode, subjects.description, 
        students.firstname, students.lastname, students.middlename,
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
        WHERE studentgrade.id = ?
        GROUP by studentgrade.id
        ");
        $stmt->bind_param("i", $_POST['id']);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        // exit();
    }
}
