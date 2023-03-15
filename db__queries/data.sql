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