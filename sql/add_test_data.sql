-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Operator-taulun testidata
INSERT INTO Operator (name, password, status) VALUES ('Ville', 'Ville123', 'ADMIN'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Operator (name, password, status) VALUES ('Timoteus', 'Timoteus123', 'USER');
-- Task_list-taulun testidata
INSERT INTO Task_list (name) VALUES ('Villen taulu');
-- Priority-listan testidata
INSERT INTO Priority (name) VALUES ('High');
-- Task-listan testidata
INSERT INTO Task (name, added, deadline) VALUES ('Siivoa', '17-01-24', '17-01-26');
-- Category-listan testidata
INSERT INTO Category (name) VALUES ('Mukavat hommat');
