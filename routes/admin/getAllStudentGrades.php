<?php

require_once '../../config/db.php';
require_once '../../functions/RemarkIdentifier.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['getStudentGrades'])) {
        $stmt = $con->prepare("SELECT
        studentgrade.*, studentsubjects.subjectid, subjects.coursecode, subjects.description, 
        students.firstname, students.lastname, students.middlename, students.course,
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
            echo "<tr><td colspan='11' class='text-center'>No Graded subjects</td>";
            die();
        }

        while ($row = $result->fetch_assoc()) :
?>
            <tr>
                <td><?php echo $row['description'] ?></td>
                <td><?php echo $row['monthly'] ?></td>
                <td><?php echo $row['firstprelim'] ?></td>
                <td><?php echo $row['secondpremlim'] ?></td>
                <td><?php echo $row['midterm'] ?></td>
                <td><?php echo $row['prefinal'] ?></td>
                <td><?php echo $row['final'] ?></td>
                <td><?php echo $row['average'] ?></td>
                <td><?php echo identifyRemark($row['graderemark']) ?></td>
                <td><?php echo $row['status'] == 1 ? "Released" : "Not Released" ?></td>
                <td><?php echo $row['course'] ?></td>
                <td><?php echo $row['section'] ?></td>
            </tr>
<?php
        endwhile;
    }
}
