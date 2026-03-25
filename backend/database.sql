CREATE database insatpulse_db;
use insatpulse_db;

CREATE TABLE User(
	id INT PRIMARY KEY auto_increment,
    username VARCHAR(30),
    email VARCHAR(50);
	password VARCHAR(50)
);
CREATE TABLE Club(
    id INT PRIMARY KEY,
    clubName VARCHAR(50)
    description VARCHAR(700),
    logoURL VARCHAR(400),
    creationDate Date,
    FOREIGN KEY (id) REFERENCES User(id)
);
CREATE TABLE Student(
    id INT PRIMARY KEY,
    fullName VARCHAR(30);
    registerDate Date;
    FOREIGN KEY (id) REFERENCES User(id)
);
CREATE TABLE Suivre(
    id_Student INT PRIMARY KEY,
    id_Club INT PRIMARY KEY,
    date Date,
    FOREIGN KEY(id_Student) REFERENCES Student(id),
    FOREIGN KEY(id_Club) REFERENCES Club(id),
);

CREATE TABLE EVENT(
    id INT PRIMARY KEY auto_increment,
    title VARCHAR(40);
    description VARCHAR(700),
    startDate Date,
    endDate Date,
    location VARCHAR(60),
    imageURL VARCHAR(60)
);

CREATE TABLE LIKE(
    id_Student INT PRIMARY KEY,
    id_Club INT PRIMARY KEY,
    date Date,
    FOREIGN KEY(id_Student) REFERENCES Student(id),
    FOREIGN KEY(id_Club) REFERENCES Club(id),

);