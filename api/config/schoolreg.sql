-- create DATABASE 'schoolreg'

CREATE DATABASE IF NOT EXISTS scolar;
USE scolar;
-- create table 'typeUser'

CREATE TABLE IF NOT EXISTS typeUser (
    idtypeuser int(12) PRIMARY KEY AUTO_INCREMENT,
    designation VARCHAR(20)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- insert into table typeuser
INSERT INTO typeUser (idtypeuser,designation) VALUES (0,'admin');
INSERT INTO typeUser (idtypeuser,designation) VALUES (1,'supervisor');
INSERT INTO typeUser (idtypeuser,designation) VALUES (2,'agent');
-- create table 'userstaff'

CREATE TABLE IF NOT EXISTS userstaff (
    id_user int(12) PRIMARY KEY AUTO_INCREMENT ,
    Fname VARCHAR(20),
    Lname VARCHAR(20),
    sexe VARCHAR(8),
    email VARCHAR(40),
    idtypeuser int(12),
    phoneNumber VARCHAR(13),
    pseudo VARCHAR(40),
    passwd VARCHAR(255),
    datereg timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- create table 'student'

CREATE TABLE IF NOT EXISTS student (
    rollNumber int(12) PRIMARY KEY ,
    Fname VARCHAR(20),
    Lname VARCHAR(20),
    sexe VARCHAR(8),
    email VARCHAR(40),
    phoneNumber VARCHAR(12),
    datereg timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- create table 'faculty'

CREATE TABLE IF NOT EXISTS faculty (
    id_faculty int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fac_name VARCHAR(30) UNIQUE,
    datecreate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- create table 'departement'

CREATE TABLE IF NOT EXISTS departement (
    id_dep int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_faculty int(12) ,
    dep_name VARCHAR(30),
    datecreate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_faculty) REFERENCES faculty(id_faculty)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- create table 'register'

CREATE TABLE IF NOT EXISTS register (
    id_register int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rollNumber int(12) ,
    id_dep int(12),
    reg_level VARCHAR(5),
    dateregis timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rollNumber) REFERENCES student(rollNumber),
    FOREIGN KEY (id_dep) REFERENCES departement(id_dep)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- create table 'type_fees'

CREATE TABLE IF NOT EXISTS type_fees (
    id int(12) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fees_name VARCHAR(20) 
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- create table 'std_pay'

CREATE TABLE IF NOT EXISTS std_pay (
    id_pay int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rollNumber int(12) ,
    bank_proof VARCHAR(25),
    bank_register VARCHAR(25),
    amount VARCHAR(10),
    id_typeFees int(12),
    id_user int(12),
    date_pay timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (rollNumber) REFERENCES student(rollNumber),
    FOREIGN KEY (id_user) REFERENCES userstaff(id_user),
    FOREIGN KEY (id_typeFees) REFERENCES type_fees(id)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;