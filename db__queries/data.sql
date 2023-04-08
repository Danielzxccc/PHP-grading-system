CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    status VARCHAR(255) DEFAULT 1 NOT NULL,
    role VARCHAR(255) NOT NULL,
)

CREATE TABLE subjects(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    coursecode VARCHAR(20) NOT NULL,
    description VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    units INT NOT NULL, 
)

CREATE TABLE students (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    studentid VARCHAR(50) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    middlename VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    number VARCHAR(255) NOT NULL,
    age INT NOT NULL,
    dateofbirth DATE NOT NULL,
    sex VARCHAR(255) NOT NULL,
    typeofscholarship VARCHAR(255) NOT NULL,
    course VARCHAR(50) NOT NULL,
    CONSTRAINT fk_student_userid FOREIGN KEY (userid)
    REFERENCES users(id)
)

CREATE TABLE professor (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    CONSTRAINT fk_professor_userid FOREIGN KEY (userid)
    REFERENCES users(id)
)

CREATE TABLE studentsubjects (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    subjectid INT NOT NULL
    CONSTRAINT fk_student_userid_subject FOREIGN KEY (userid)
    REFERENCES users(id),
    CONSTRAINT fk_student_subjectid_subject FOREIGN KEY (userid)
    REFERENCES subjects(id)
)

CREATE TABLE studentgrade(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    studentsubjectid INT NOT NULL,
    monthly INT NOT NULL,
    firstprelim INT NOT NULL,
    secondpremlim INT NOT NULL,
    midterm INT NOT NULL,
    prefinal INT NOT NULL,
    final INT NOT NULL,
    schoolyear VARCHAR(255) NOT NULL,
    semester INT NOT NULL,
    section INT NOT NULL
    status INT DEFAULT 0,
    graderemark VARCHAR(255),
    CONSTRAINT fk_student_grade_subject FOREIGN KEY (studentsubjectid)
    REFERENCES studentsubjects(id) ON DELETE CASCADE
)

SELECT studentgrade.*, studentsubjects.subjectid, subjects.coursecode
FROM studentgrade 
JOIN studentsubjects ON studentsubjects.id = studentgrade.studentsubjectid
JOIN subjects ON studentsubjects.subjectid = subjects.id 
WHERE studentsubjects.studentid = 8

SELECT
  studentgrade.*, studentsubjects.subjectid, subjects.coursecode, students.firstname,
  ROUND(AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6), 2) AS average,
  CASE
    WHEN graderemark != '' THEN graderemark
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 97 AND 100 THEN '1.00'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 93 AND 96 THEN '1.25'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 90 AND 92 THEN '1.50'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 86 AND 89 THEN '1.75'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 82 AND 85 THEN '2.00'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 76 AND 81 THEN '2.50'
    WHEN AVG((monthly + firstprelim + secondpremlim + midterm + prefinal + final)/6) BETWEEN 75 AND 75 THEN '3.00 (PASSED)'
    ELSE '5.00 (FAILED)'
  END AS grades
FROM studentgrade
JOIN studentsubjects ON studentsubjects.id = studentgrade.studentsubjectid
JOIN subjects ON studentsubjects.subjectid = subjects.id
JOIN students ON studentsubjects.studentid = students.id
WHERE studentsubjects.studentid = 7
GROUP by studentgrade.id
;

SELECT
studentgrade.*, studentsubjects.subjectid, subjects.coursecode, subjects.description, 
students.firstname, students.lastname, students.middlename, CONCAT(professor.lastname, ", ", professor.firstname) as profname,
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
GROUP by studentgrade.id