<?php
session_start();

require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function message($status, $message)
    {
        $msg = array(
            "success" => $status,
            "message" => $message
        );
        echo json_encode($msg);
        die();
    }
    //fetch student based on parameters
    if (isset($_POST['getAllStudents'])) {
        $searchParam = "%" . $_POST['search'] . "%";
        $stmt = $con->prepare("SELECT students.* 
        FROM students 
        JOIN users ON students.userid = users.id
            WHERE 
            students.lastname LIKE ? AND users.isApproved = 1 
            OR  students.firstname LIKE ? AND users.isApproved = 1 
            OR  students.middlename LIKE ? AND users.isApproved = 1 
            OR  students.id LIKE ? AND users.isApproved = 1 
            OR  students.studentid LIKE ? AND users.isApproved = 1 
            OR  students.course LIKE ? AND users.isApproved = 1 
        LIMIT 100");
        $stmt->bind_param(
            "sssiss",
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $output = '';
        while ($row = $result->fetch_assoc()) :
            $output .= "
        <tr>
            <td><input name='student' type='radio' class='student-radio' value='" . $row['id'] . "' /></td>
            <td>" . $row['studentid'] . "</td>
            <td>" . $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename'] . ".</td>
            <td>" . $row['course'] . "</td>
        </tr>
        ";
        endwhile;
        echo $output;
        exit();
    }
    //fetch single student info
    if (isset($_POST['getStudentInfo'])) {
        $stmt = $con->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        exit();
    }

    if (isset($_POST['getSubjectInfo'])) {
        $stmt = $con->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode($row);
        exit();
    }

    if (isset($_POST['getStudentSubjects'])) {
        $stmt = $con->prepare("SELECT studentsubjects.id as id, 
        studentsubjects.subjectid as studentsubject, 
        students.lastname, students.firstname, students.middlename, 
        students.course, students.studentid, subjects.coursecode, 
        subjects.description, subjects.units
        FROM studentsubjects
        JOIN students ON students.id = studentsubjects.studentid
        JOIN subjects ON subjects.id = studentsubjects.subjectid
        WHERE students.id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $output = '';
        if (isset($_POST['getCourseCode'])) {
            $output .= "<option value='0'>Select a subject</option>";
            while ($row = $result->fetch_assoc()) :
                $output .= "
                    <option value='" .  $row['studentsubject'] . "' data-id='" . $row['id'] . "'>" . $row['coursecode'] . "</option>
                ";
            endwhile;
        } else {
            while ($row = $result->fetch_assoc()) :
                $output .= "
                    <tr>
                        <td class='d-print-none'>
                        <input type='radio' name='studentsubject' class='subjectList' value='" . $row['id'] . "' data-id='" . $row['studentsubject'] . "' />
                        </td>
                        <td>" . $row['lastname'] . ", " . $row['firstname'] . " " . $row['middlename'] . ".</td>
                        <td>" . $row['course'] . "</td>
                        <td>1st Year</td>
                        <td>" . $row['studentid'] . "</td>
                        <td>" . $row['coursecode'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['units'] . "</td>
                    </tr>
                ";
            endwhile;
        }
        echo $output;
        exit();
    }

    if (isset($_POST['getIncomingStudents'])) {
        $stmt = $con->prepare("SELECT students.*, users.status FROM grading.students 
        JOIN users ON users.id = students.userid
        WHERE users.isApproved = 0 AND users.role = 'student'");
        try {
            $stmt->execute();
        } catch (Exception $th) {
            echo 'ERROR';
            exit();
        }
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) :
?>
            <tr>
                <td><?php echo $row['studentid'] ?></td>
                <td><?php echo $row['firstname'] ?></td>
                <td><?php echo $row['middlename'] ?></td>
                <td><?php echo $row['lastname'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['number'] ?></td>
                <td><?php echo $row['age'] ?></td>
                <td><?php echo $row['dateofbirth'] ?></td>
                <td><?php echo $row['sex'] ?></td>
                <td><?php echo $row['typeofscholarship'] ?></td>
                <td><?php echo $row['course'] ?></td>
                <td><?php echo $row['yearlevel'] ?></td>
                <td>
                    <button class="mx-1 btn btn-success accept-btn" data-id="<?php echo $row['userid'] ?>" data-name="<?php echo $row['lastname'] ?>">Accept</button>
                </td>
            </tr>
<?php
        endwhile;
    }
}
