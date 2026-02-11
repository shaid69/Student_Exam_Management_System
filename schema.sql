CREATE DATABASE student_exam CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_exam;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  verify_token VARCHAR(100) DEFAULT NULL,
  verified TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
  sid INT PRIMARY KEY,
  sname VARCHAR(200),
  program VARCHAR(100),
  sec_no INT
);

CREATE TABLE course_offerings (
  sec_no INT PRIMARY KEY,
  time VARCHAR(100),
  room VARCHAR(100),
  course_no VARCHAR(50),
  semester VARCHAR(50),
  year INT
);

CREATE TABLE exams (
  eid INT PRIMARY KEY,
  ename VARCHAR(200),
  eplace VARCHAR(200),
  etime VARCHAR(100)
);

CREATE TABLE takes (
  sid INT,
  eid INT,
  sec_no INT,
  marks DOUBLE,
  PRIMARY KEY (sid,eid),
  FOREIGN KEY (sid) REFERENCES students(sid) ON DELETE CASCADE,
  FOREIGN KEY (eid) REFERENCES exams(eid) ON DELETE CASCADE,
  FOREIGN KEY (sec_no) REFERENCES course_offerings(sec_no) ON DELETE SET NULL
);
