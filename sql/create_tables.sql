CREATE TABLE Kurssi(
    kurssitunnus SERIAL PRIMARY KEY,
    nimi varchar(150),
    yliopisto varchar(150) NOT NULL
);

CREATE TABLE Opiskelija(
    opiskelijatunnus SERIAL PRIMARY KEY,
    nimi varchar(100) NOT NULL,
    kayttajatunnus varchar(50) NOT NULL,
    salasana varchar(50) NOT NULL
);

CREATE TABLE Opiskelijan_kurssi(
    opiskelija INTEGER REFERENCES Opiskelija(opiskelijatunnus),
    kurssi INTEGER REFERENCES Kurssi(kurssitunnus)
);

CREATE TABLE Muistiinpano(
    id SERIAL PRIMARY KEY,
    opiskelija INTEGER REFERENCES Opiskelija(opiskelijatunnus),
    kurssi INTEGER REFERENCES Kurssi(kurssitunnus),
    aihe Varchar(200),
    osoite Varchar(512) NOT NULL,
    muokkauspaiva DATE,
    julkinen boolean DEFAULT FALSE
);
