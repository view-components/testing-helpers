DROP DATABASE IF EXISTS DB_NAME;
CREATE DATABASE IF NOT EXISTS DB_NAME;
USE DB_NAME;

DROP TABLE IF EXISTS test_users;
CREATE TABLE IF NOT EXISTS test_users (
  id int(10) NOT NULL,
  name varchar(255) NOT NULL,
  role varchar(31) NOT NULL,
  birthday date NOT NULL,
  PRIMARY KEY (id)
);

DELETE FROM test_users;

INSERT INTO test_users VALUES (1, 'John', 'Admin', '1970-01-16');
INSERT INTO test_users VALUES (2, 'Max', 'Manager', '1980-11-20');
INSERT INTO test_users VALUES (3, 'Anna', 'Manager', '1987-03-30');
INSERT INTO test_users VALUES (4, 'Lisa', 'User', '1989-04-21');
INSERT INTO test_users VALUES (5, 'Eric', 'User', '1990-10-23');

INSERT INTO test_users VALUES (6, 'David', 'User', '1990-10-23');
INSERT INTO test_users VALUES (7, 'Bruce', 'User', '1977-09-14');
INSERT INTO test_users VALUES (8, 'Julia', 'User', '1994-03-05');
INSERT INTO test_users VALUES (9, 'Ben', 'User', '1991-11-13');
INSERT INTO test_users VALUES (10, 'Frank', 'Manager', '1964-10-29');
INSERT INTO test_users VALUES (11, 'Phil', 'User', '1972-08-17');
INSERT INTO test_users VALUES (12, 'Nikita', 'User', '1973-04-17');
INSERT INTO test_users VALUES (13, 'Steven', 'User', '1983-03-21');
INSERT INTO test_users VALUES (14, 'Ross', 'User', '1982-07-14');
INSERT INTO test_users VALUES (15, 'Sammy', 'User', '1982-07-24');

INSERT INTO test_users VALUES (16, 'Victor', 'User', '1979-01-23');
INSERT INTO test_users VALUES (17, 'Martin', 'Manager', '2001-01-04');
INSERT INTO test_users VALUES (18, 'Florin', 'User', '2002-06-06');
INSERT INTO test_users VALUES (19, 'Diego', 'User', '1987-05-11');
INSERT INTO test_users VALUES (20, 'Robert', 'Admin', '1984-02-01');
INSERT INTO test_users VALUES (21, 'Peter', 'User', '1994-05-12');
INSERT INTO test_users VALUES (22, 'Sebastian', 'User', '1991-11-16');
INSERT INTO test_users VALUES (23, 'Rafael', 'User', '1993-05-04');