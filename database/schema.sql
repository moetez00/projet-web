create database insatpulse_db;
use insatpulse_db;

CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','club_Confirmed','admin', 'club_NotConfirmed') NOT NULL,
    profile_img VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE student (
    user_id INT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    major VARCHAR(100) DEFAULT NULL,
    birthday DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);


CREATE TABLE club (
    user_id INT PRIMARY KEY ,
    name VARCHAR(150) NOT NULL,
    description VARCHAR(120) DEFAULT NULL,
    category VARCHAR(100) DEFAULT NULL,
    cover_img VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE `event` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    club_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description VARCHAR(500) DEFAULT NULL,
    event_date  DATETIME NOT NULL,
    place VARCHAR(200) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES club(user_id) ON DELETE CASCADE
);


CREATE TABLE follow (
    student_id INT NOT NULL,
    club_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, club_id),
    FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,
    FOREIGN KEY (club_id)    REFERENCES club(user_id)    ON DELETE CASCADE
);


CREATE TABLE `like` (
    student_id INT NOT NULL,
    event_id   INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, event_id),
    FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,
    FOREIGN KEY (event_id)   REFERENCES event(id)   ON DELETE CASCADE
);
