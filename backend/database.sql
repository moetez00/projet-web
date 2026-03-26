CREATE database insatpulse_db;
use insatpulse_db;

CREATE TABLE USER(
	id INT PRIMARY KEY auto_increment,
    username VARCHAR(30) UNIQUE,
    email VARCHAR(50) UNIQUE,
	password VARCHAR(50),
    registerDate Date
);
CREATE TABLE CLUB(
    id INT PRIMARY KEY,
    clubName VARCHAR(50),
    description VARCHAR(700) default NULL,
    logoURL VARCHAR(400) default NULL,
    FOREIGN KEY (id) REFERENCES USER(id)
);
CREATE TABLE STUDENT(
    id INT PRIMARY KEY,
    fullName VARCHAR(30),
    FOREIGN KEY (id) REFERENCES USER(id)
);
CREATE TABLE FOLLOW(
    id_Student INT,
    id_Club INT,
    dateFollow Date,
    FOREIGN KEY(id_Student) REFERENCES STUDENT(id),
    FOREIGN KEY(id_Club) REFERENCES CLUB(id),
	PRIMARY KEY(id_Student,id_Club)
);

CREATE TABLE EVENT(
    id INT PRIMARY KEY auto_increment,
    id_Club INT,
    title VARCHAR(40),
    description VARCHAR(700),
    startDate Date,
    endDate Date,
    loc VARCHAR(60),
    imageURL VARCHAR(60),
    FOREIGN KEY(id_Club) REFERENCES CLUB(id)
);

CREATE TABLE LIKES(
    id_Student INT,
    id_Club INT,
    dateLike Date,
    FOREIGN KEY(id_Student) REFERENCES STUDENT(id),
    FOREIGN KEY(id_Club) REFERENCES CLUB(id),
	PRIMARY KEY(id_Student,id_Club)
);