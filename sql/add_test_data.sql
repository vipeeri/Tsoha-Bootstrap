-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Operator-taulun testidata
INSERT INTO Operator (username, password, status) VALUES ('admin', 'admin', 'true'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
-- Task_list-taulun testidata
INSERT INTO Task_list (name) VALUES ('Villen taulu');
-- Priority-listan testidata
INSERT INTO Priority (name) VALUES ('High');
-- Task-listan testidata
-- Category-listan testidata
INSERT INTO Category (name) VALUES ('School');
INSERT INTO Category (name) VALUES ('Work');
INSERT INTO Category (name) VALUES ('Home');
