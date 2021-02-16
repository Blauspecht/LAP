
-- SELECT -----------------------------------------------------------------------------------------

SELECT l.Artnr
	  ,a.Bezeichnung
FROM artikel a
	INNER JOIN lager l ON l.Artnr = a.Anr
WHERE l.Bestand - (l.Mindbest + l.Reserviert) < 3;

SELECT a.Bezeichnung
	  ,SUM(t.Anzahl) AS 'Anzahl Einzelteile'
FROM artikel a
	INNER JOIN teilestruktur t ON t.Artnr = a.Anr
GROUP BY a.Bezeichnung;


-- INSERT -----------------------------------------------------------------------------------------

INSERT INTO mydb.mytbl (ID, Name)
VALUES('1', 'Anna'),
	('2', 'Peter'),
	('3', 'Hans'),
	('4', 'Lisa'),
	('5', 'Robert'),
	('6', 'Hanna'),
	('7', 'Klaus');


-- UPDATE -----------------------------------------------------------------------------------------

-- SET SQL_SAFE_UPDATES = 0;
UPDATE mydb.mytbl
SET Name = 'Georg', Number = '4'
WHERE ID = 1;


-- DELETE -----------------------------------------------------------------------------------------

DELETE FROM mydb.mytbl;

DELETE FROM mydb.mytbl
WHERE ID = '2';

-- ------------------------------------------------------------------------------------------------
