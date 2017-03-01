-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Operator(
    id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
    username varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
    password varchar(50) NOT NULL,
    status INTEGER DEFAULT 0
);

CREATE TABLE Priority(
    id SERIAL PRIMARY KEY,
    name varchar(50)
);

CREATE TABLE Task(
     id SERIAL PRIMARY KEY,
     priority_id INTEGER REFERENCES Priority (id), -- Viiteavain Priority-tauluun
     operator_id INTEGER REFERENCES Operator (id), -- Viiteavain Operator-tauluun
     done INTEGER DEFAULT 0,
     name varchar(120) NOT NULL,
     added DATE,
     deadline DATE
);

CREATE TABLE Category(
    id SERIAL PRIMARY KEY,
    name varchar(50),
    operator_id INTEGER REFERENCES Operator (id)
);

CREATE TABLE Task_category(
    id SERIAL PRIMARY KEY,
    task_id INTEGER REFERENCES Task (id),
    category_id INTEGER REFERENCES Category (id)
);





