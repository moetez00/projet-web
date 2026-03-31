-- =============================================================
-- schema.sql — Database foundation for the university social platform
-- All models (includes/models/) query these tables.
-- Import this file once into MySQL before running the app.
-- =============================================================

-- Base user account (shared by students and clubs via single-table inheritance)
CREATE TABLE user (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    email      VARCHAR(255) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,              -- bcrypt hash
    role       ENUM('student', 'club') NOT NULL,
    avatar     VARCHAR(255) DEFAULT NULL,          -- path under uploads/
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Student-specific profile (1-to-1 with user where role='student')
CREATE TABLE student (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL UNIQUE,
    last_name  VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    major      VARCHAR(100) DEFAULT NULL,
    year       TINYINT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Club-specific profile (1-to-1 with user where role='club')
CREATE TABLE club (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL UNIQUE,
    name        VARCHAR(150) NOT NULL,
    description TEXT DEFAULT NULL,
    category    VARCHAR(100) DEFAULT NULL,
    cover       VARCHAR(255) DEFAULT NULL,         -- path under uploads/
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Events created by clubs
CREATE TABLE event (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    club_id     INT NOT NULL,
    title       VARCHAR(200) NOT NULL,
    description TEXT DEFAULT NULL,
    event_date  DATETIME NOT NULL,
    location    VARCHAR(200) DEFAULT NULL,
    image       VARCHAR(255) DEFAULT NULL,         -- path under uploads/
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (club_id) REFERENCES club(id) ON DELETE CASCADE
);

-- Students following clubs (many-to-many)
CREATE TABLE follow (
    student_id INT NOT NULL,
    club_id    INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, club_id),
    FOREIGN KEY (student_id) REFERENCES student(id) ON DELETE CASCADE,
    FOREIGN KEY (club_id)    REFERENCES club(id)    ON DELETE CASCADE
);

-- Students liking events (many-to-many)
CREATE TABLE `like` (
    student_id INT NOT NULL,
    event_id   INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (student_id, event_id),
    FOREIGN KEY (student_id) REFERENCES student(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id)   REFERENCES event(id)   ON DELETE CASCADE
);
