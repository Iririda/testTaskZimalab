CREATE USER 'service' IDENTIFIED BY '12345';
CREATE DATABASE test;
USE test;

CREATE TABLE accounts (
    id INTEGER NOT NULL AUTO_INCREMENT,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    company VARCHAR(100),
    position VARCHAR(50),
    phone1 VARCHAR(20),
    phone2 VARCHAR(20),
    phone3 VARCHAR(20),
    PRIMARY KEY (id),
    UNIQUE (email)
);

GRANT SELECT, INSERT, UPDATE, DELETE ON accounts TO 'service';
