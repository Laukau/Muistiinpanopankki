CREATE TABLE Course(
    id SERIAL PRIMARY KEY,
    title varchar(150) NOT NULL,
    university varchar(150) NOT NULL,
    description varchar(500)
);

CREATE TABLE Student(
    id SERIAL PRIMARY KEY,
    student_name varchar(100) NOT NULL,
    username varchar(50) NOT NULL,
    password varchar(50) NOT NULL
);

CREATE TABLE Students_course(
    id SERIAL PRIMARY KEY,
    student INTEGER REFERENCES Student(id),
    course INTEGER REFERENCES Course(id)
);

CREATE TABLE Note(
    id SERIAL PRIMARY KEY,
    student INTEGER REFERENCES Student(id),
    course INTEGER REFERENCES Course(id),
    subject Varchar(200) NOT NULL,
    address Varchar(512) NOT NULL,
    modified DATE,
    published boolean DEFAULT FALSE
);
