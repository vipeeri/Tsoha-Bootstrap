-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Operator(
    id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
    name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
    password varchar(50) NOT NULL,
    status varchar(50) NOT NULL
);

CREATE TABLE Priority(
    id SERIAL PRIMARY KEY,
    name varchar(50)
);

CREATE TABLE Task(
     id SERIAL PRIMARY KEY,
     priority_id INTEGER REFERENCES Priority (id), -- Viiteavain Priority-tauluun
     name varchar(120) NOT NULL,
     added DATE,
     deadline DATE
);

CREATE TABLE Task_list(
    id SERIAL PRIMARY KEY,
    operator_id INTEGER REFERENCES Operator (id), -- Viiteavain Operator-tauluun
    task_id INTEGER REFERENCES Task (id),
    name varchar(50)
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    name varchar(120)
);

CREATE TABLE Task_category(
    category_id INTEGER REFERENCES Category (id),
    task_id INTEGER REFERENCES Task (id)
);



