CREATE database insatpulse_db;
use insatpulse_db;

CREATE TABLE User(
	id INT PRIMARY KEY auto_increment,
    username VARCHAR(30) UNIQUE,
    email VARCHAR(50) UNIQUE,
	password VARCHAR(50),
    registerDate Date
);
CREATE TABLE Club(
    id INT PRIMARY KEY,
    clubName VARCHAR(50),
    description VARCHAR(700) default NULL,
    logoURL VARCHAR(400) default NULL,
    FOREIGN KEY (id) REFERENCES User(id)
);
CREATE TABLE Student(
    id INT PRIMARY KEY,
    fullName VARCHAR(30),
    FOREIGN KEY (id) REFERENCES User(id)
);
CREATE TABLE Follow(
    id_Student INT PRIMARY KEY,
    id_Club INT PRIMARY KEY,
    dateFollow Date,
    FOREIGN KEY(id_Student) REFERENCES Student(id),
    FOREIGN KEY(id_Club) REFERENCES Club(id)
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
    FOREIGN KEY(id_Club) REFERENCES Club(id)
);

CREATE TABLE LIKE(
    id_Student INT PRIMARY KEY,
    id_Club INT PRIMARY KEY,
    dateLike Date,
    FOREIGN KEY(id_Student) REFERENCES Student(id),
    FOREIGN KEY(id_Club) REFERENCES Club(id)

);