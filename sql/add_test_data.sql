-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Operator-taulun testidata
INSERT INTO Operator (username, password, status) VALUES ('admin', 'admin', 1); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
-- Task_list-taulun testidata
-- Priority-listan testidata
INSERT INTO Priority (name) VALUES ('High');
INSERT INTO Priority (name) VALUES ('Medium');
INSERT INTO Priority (name) VALUES ('Low');
-- Task-listan testidata
-- Category-listan testidata
INSERT INTO Category (name, operator_id) VALUES ('School', 1);
INSERT INTO Category (name, operator_id) VALUES ('Work', 1);
INSERT INTO Category (name, operator_id) VALUES ('Home', 1);
INSERT INTO Category (name, operator_id) VALUES ('Shopping', 1);

INSERT INTO Task (name, added, deadline) VALUES ('Tsoha', '02.02.2017', '02.02.2018');
INSERT INTO Task (name, added, deadline) VALUES ('Stuff', '02.02.2017', '02.02.2018');
INSERT INTO Task (name, added, deadline) VALUES ('Buy milk', '02.02.2017', '02.02.2018');
INSERT INTO Task (name, added, deadline) VALUES ('Ripperiino', '02.02.2017', '02.02.2018');

INSERT INTO Task_category (task_id, category_id) VALUES (1, 1);
INSERT INTO Task_category (task_id, category_id) VALUES (1, 2);
INSERT INTO Task_category (task_id, category_id) VALUES (2, 1);
INSERT INTO Task_category (task_id, category_id) VALUES (2, 2);
INSERT INTO Task_category (task_id, category_id) VALUES (3, 3);
INSERT INTO Task_category (task_id, category_id) VALUES (3, 4);
INSERT INTO Task_category (task_id, category_id) VALUES (4, 3);
