USE filmverwaltung;

INSERT INTO Studio(id, name) VALUES
(1, 'Bavaria Filmstudios'),
(2, 'Great American Films'),
(3, 'Touchstones Pictures'),
(4, 'Warner Brothers Pictures');

INSERT INTO Film(id, titel, erscheinungsdatum, Studio_id) VALUES
(3000, 'Dirty Dancing', '1987-8-21', 2),
(3001, 'Sister Act', '1992-5-29', 3),
(3002, 'Harry Potter u. der Stein der Weisen', '2001-23-11', 4),
(3003, 'Casanova', '2006-2-9', 3),
(3004, 'Die unendliche Geschichte', '1984-5-20', 1),
(3005, 'Die Welle', '2008-3-13', 1),
(3006, 'Krieg in Chinatown', '1987-9-25', 2),
(3007, 'I Am Legend', '2008-1-10', 4),
(3008, 'Transcendence', '2014-4-18', 4);

INSERT INTO Land (id, name)
VALUES (1, 'Deutschland'),
(2, 'USA'),
(3, 'Indien');

INSERT INTO schauspieler (vorname, nachname, land_id)
VALUES ('Noah', 'Hathaway', 2),
('Thomas', 'Hill', 3),
('Max', 'Riemelt', 1),
('Whoopi', 'Goldberg', 2),
('Patrick', 'Swayze', 2);

INSERT INTO film_schauspieler(film_id, schauspieler_id)
VALUES (3003, 1),
(3002, 2),
(3004, 3),
(3001, 4);