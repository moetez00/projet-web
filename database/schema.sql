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

-- USERS (password shown in comment)
INSERT INTO user (email, username, password, role, profile_img) VALUES
('admin@insat.tn', 'admin1', '0192023a7bbd73250516f069df18b500', 'admin', NULL), -- admin123

('club1@insat.tn', 'gdsc', 'e99a18c428cb38d5f260853678922e03', 'club_Confirmed', NULL), -- abc123
('club2@insat.tn', 'ieee', '5f4dcc3b5aa765d61d8327deb882cf99', 'club_Confirmed', NULL), -- password
('club3@insat.tn', 'gamingclub', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'club_NotConfirmed', NULL), -- qwerty

('student1@insat.tn', 'taz', 'e10adc3949ba59abbe56e057f20f883e', 'student', NULL), -- 123456
('student2@insat.tn', 'amira', '0d107d09f5bbe40cade3de5c71e9e9b7', 'student', NULL), -- letmein
('student3@insat.tn', 'youssef', '21232f297a57a5a743894a0e4a801fc3', 'student', NULL), -- admin
('student4@insat.tn', 'sarra', '40be4e59b9a2a2b5dffb918c0e86b3d7', 'student', NULL), -- welcome
('student5@insat.tn', 'karim', 'f25a2fc72690b780b2a14e140ef6a9e0', 'student', NULL), -- iloveyou
('student6@insat.tn', 'leila', 'e99a18c428cb38d5f260853678922e03', 'student', NULL); -- abc123

-- STUDENTS
INSERT INTO student (user_id, fullname, major, birthday) VALUES
(5, 'Taz B', 'Software Engineering', '2002-05-10'),
(6, 'Amira K', 'Data Science', '2003-03-22'),
(7, 'Youssef M', 'Networks', '2001-11-15'),
(8, 'Sarra L', 'AI', '2002-07-30'),
(9, 'Karim H', 'Cybersecurity', '2000-01-19'),
(10, 'Leila S', 'Embedded Systems', '2003-09-12');

-- CLUBS
INSERT INTO club (user_id, name, description, category, cover_img) VALUES
(2, 'GDSC INSAT', 'Google Developer Student Club', 'Tech', NULL),
(3, 'IEEE INSAT', 'Engineering and innovation', 'Engineering', NULL),
(4, 'Gaming Club', 'For gamers and esports lovers', 'Fun', NULL);

-- EVENTS
INSERT INTO event (club_id, title, description, event_date, place, image) VALUES
(2, 'Flutter Workshop', 'Learn Flutter basics', '2026-05-01 10:00:00', 'INSAT Hall A', NULL),
(2, 'Hackathon 2026', '24h coding challenge', '2026-06-15 09:00:00', 'INSAT', NULL),

(3, 'AI Conference', 'Talks about AI trends', '2026-04-20 14:00:00', 'Auditorium', NULL),
(3, 'Robotics Workshop', 'Build your robot', '2026-05-10 10:00:00', 'Lab 3', NULL),

(4, 'FIFA Tournament', 'Compete and win', '2026-04-25 16:00:00', 'Gaming Room', NULL),
(4, 'LAN Party', 'Multiplayer games night', '2026-05-30 20:00:00', 'INSAT Basement', NULL);

-- FOLLOWS
INSERT INTO follow (student_id, club_id) VALUES
(5,2),(5,3),
(6,2),(6,4),
(7,3),
(8,2),(8,3),(8,4),
(9,4),
(10,2),(10,3);

-- LIKES
INSERT INTO `like` (student_id, event_id) VALUES
(5,1),(5,2),(5,3),
(6,1),(6,4),
(7,3),(7,4),
(8,1),(8,2),(8,5),
(9,5),(9,6),
(10,2),(10,3),(10,4);