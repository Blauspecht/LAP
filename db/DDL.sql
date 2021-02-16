
-- CREATE AND DELETE DATABASE/SCHEMA --------------------------------------------------------------

-- Database (= Schema) --
CREATE DATABASE mydb;
-- CREATE DATABASE IF NOT EXISTS mydb;
DROP DATABASE IF EXISTS mydb;

-- Schema (= Database) --
CREATE SCHEMA myschema;
-- CREATE SCHEMA IF NOT EXISTS mydb;
DROP SCHEMA IF EXISTS myschema;


-- CREATE AND DELETE TABLES -----------------------------------------------------------------------

-- Table [Datatypes] --
-- USE mydb;
CREATE TABLE IF NOT EXISTS mytbl (
  `ID` INT PRIMARY KEY,
  `Name` NVARCHAR(50) ,
  `Number` INT(10),
  `Date` DATE,
  `DateTime` DATETIME,
  `Bool` BIT);
  
DROP TABLE IF EXISTS mytbl;

-- Table [Constraints] --
CREATE TABLE IF NOT EXISTS mytbl (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(50) NOT NULL UNIQUE,
  `Number` INT(10) NOT NULL,
  `Date` DATE NOT NULL,
  `DateTime` DATETIME NOT NULL,
  `Bool` BIT NOT NULL);
  
DROP TABLE IF EXISTS mytbl;


-- TABLE RELATIONSHIP -----------------------------------------------------------------------------

-- Table [1:1] --
CREATE TABLE IF NOT EXISTS mytbl_1 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(200) NOT NULL,
  `Date` DATE NULL);
  
CREATE TABLE IF NOT EXISTS mytbl_2 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(100) NOT NULL);

CREATE TABLE IF NOT EXISTS mytbl_1_mytbl_2 (
  `mytbl_1_ID` INT NOT NULL UNIQUE,
  `mytbl_2_ID` INT NOT NULL UNIQUE,
  FOREIGN KEY (mytbl_1_ID) REFERENCES mytbl_1(ID),
  FOREIGN KEY (mytbl_2_ID) REFERENCES mytbl_2(ID));


-- Table [1:n] --
CREATE TABLE IF NOT EXISTS mytbl_1 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(200) NOT NULL,
  `Date` DATE NULL);
  
CREATE TABLE IF NOT EXISTS mytbl_2 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(100) NOT NULL,
  `mytbl_1_ID` INT NOT NULL,
  FOREIGN KEY (mytbl_1_ID) REFERENCES mytbl_1(ID));
  
  
-- Table [n:m] --
CREATE TABLE IF NOT EXISTS mytbl_1 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(200) NOT NULL,
  `Date` DATE NULL);
  
CREATE TABLE IF NOT EXISTS mytbl_2 (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` NVARCHAR(100) NOT NULL);

CREATE TABLE IF NOT EXISTS mytbl_1_mytbl_2 (
  `mytbl_1_ID` INT NOT NULL,
  `mytbl_2_ID` INT NOT NULL,
  FOREIGN KEY (mytbl_1_ID) REFERENCES mytbl_1(ID),
  FOREIGN KEY (mytbl_2_ID) REFERENCES mytbl_2(ID));


-- CREATE VIEW (+ JOIN) ---------------------------------------------------------------------------

CREATE VIEW mytbl_1_mytbl_2 AS
SELECT m1.ID
	  ,m1.Name
      ,m1.Date
      ,m2.ID
      ,m2.Name
FROM mytbl_1 m1
	INNER JOIN mytbl_2 m2 ON m2.ID = m1.ID
WHERE m1.Date >= '2019-12-25 00:00:00';


-- ALTER TABLE ------------------------------------------------------------------------------------

-- Add Constraint --
ALTER TABLE mytbl_2
ADD FOREIGN KEY (mytbl_1_ID) REFERENCES mytbl_1(ID);

ALTER TABLE mytbl_2
ADD UNIQUE (Number);

-- Remove Constraint --
ALTER TABLE mytbl_2
DROP FOREIGN KEY name_of_FK;

ALTER TABLE mytbl_2
DROP INDEX Number;

-- Add Column --
ALTER TABLE mytbl_2
ADD COLUMN `Number` INT(10) NOT NULL;

-- ------------------------------------------------------------------------------------------------
