
-- CREATE AND DELETE ------------------------------------------------------------------------------

-- Create User --
CREATE USER 'someuser'@'localhost' IDENTIFIED BY 'password';

-- Delete User --
DROP USER 'someuser'@'localhost';
-- SELECT user FROM mysql.user;


-- GRANT PRIVILEGES -------------------------------------------------------------------------------

-- Global Privileges --
GRANT ALL ON *.* TO 'someuser'@'localhost';
GRANT SELECT, INSERT ON *.* TO 'someuser'@'localhost';

-- Database Privileges --
GRANT ALL ON mydb.* TO 'someuser'@'localhost';
GRANT SELECT, INSERT ON mydb.* TO 'someuser'@'localhost';

-- Table Privileges --
GRANT ALL ON mydb.mytbl TO 'someuser'@'localhost';
GRANT SELECT, INSERT ON mydb.mytbl TO 'someuser'@'localhost';
-- GRANT [ SELECT | INSERT | UPDATE | DELETE | ... ] ON mydb.mytbl TO 'someuser'@'localhost';

-- Functions/Procedures Privileges --
GRANT EXECUTE ON FUNCTION func TO 'someuser'@'localhost';
GRANT EXECUTE ON PROCEDURE prod TO 'someuser'@'localhost';


-- REVOKE PRIVILEGES ------------------------------------------------------------------------------

-- Revoke Privileges --
REVOKE ALL ON mydb.mytbl FROM 'someuser'@'localhost';
REVOKE DELETE, UPDATE ON mydb.mytbl FROM 'someuser'@'localhost';
-- REVOKE [ SELECT | INSERT | UPDATE | DELETE | ... ] ON mydb.mytbl FROM 'someuser'@'localhost';

-- Functions/Procedures --
REVOKE EXECUTE ON FUNCTION func FROM 'someuser'@'localhost';
REVOKE EXECUTE ON PROCEDURE prod FROM 'someuser'@'localhost';


-- OTHER ------------------------------------------------------------------------------------------

-- Show Privileges --
SHOW GRANTS FOR 'someuser'@'localhost';

FLUSH PRIVILEGES;

-- ------------------------------------------------------------------------------------------------
