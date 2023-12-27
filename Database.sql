-- ################### SQL SYNTHAX ###################
USE Master;
GO;
CREATE DATABASE basevol;
GO;
USE basevol;
GO;
CREATE TABLE aeroport(
    idAeroport int identity(1,1) NOT NULL UNIQUE,
    nomAeroport VARCHAR(15) NOT NULL,
    CONSTRAINT PK_idAeroport PRIMARY KEY (idAeroport)
);
GO;
CREATE TABLE avions(
    idAvion int identity(1,1) NOT NULL UNIQUE,
    categorieAvion VARCHAR(15) NOT NULL,
    nomAvion VARCHAR(15) NOT NULL,
    nombrePlace int NOT NULL,
    photo TEXT NOT NULL,
    CONSTRAINT PK_idAvion PRIMARY KEY (idAvion)
);
GO;
CREATE TABLE vols(
    idVol int identity(1,1) NOT NULL UNIQUE,
    aeroportDepart int NOT NULL,
    aeroportArrive int NOT NULL,
    dateDepart date NOT NULL,
    heureDepart int NOT NULL,
    idAvion int NOT NULL,
    CONSTRAINT PK_idVol PRIMARY KEY (idVol),
    CONSTRAINT FK_aeroportDT FOREIGN KEY (aeroportDepart) REFERENCES aeroport(idAeroport),
    CONSTRAINT FK_aeroportAv FOREIGN KEY (aeroportArrive) REFERENCES aeroport(idAeroport),
    CONSTRAINT FK_idAvion FOREIGN KEY (idAvion) REFERENCES avions(idAvion)
);
GO;
CREATE TABLE tickets(
    idTicket int identity(1,1) NOT NULL UNIQUE,
    idVol int NOT NULL,
    prix float NOT NULL,
    numeroPlace int NOT NULL,
    CONSTRAINT PK_idTicket PRIMARY KEY (idTicket),
    CONSTRAINT FK_Vol FOREIGN KEY (idVol) REFERENCES vols(idVol)
);
GO;
CREATE TABLE escales(
    idEscale int identity(1,1) NOT NULL UNIQUE,
    idVol int NOT NULL,
    idAeroport int NOT NULL,
    CONSTRAINT PK_idEscale PRIMARY KEY (idEscale),
    CONSTRAINT FK_escaleVol FOREIGN KEY (idVol) REFERENCES vols(idVol),
    CONSTRAINT FK_escaleAeroport FOREIGN KEY (idAeroport) REFERENCES aeroport(idAeroport)
);
GO;

ALTER TABLE tickets;
GO;
ADD CONSTRAINT Check_NumPlace CHECK ( numeroPlace < 400 );
GO;

DELETE FROM vols WHERE dateDepart BETWEEN 2015-00-00 AND 2015-12-31;
GO;

SELECT * FROM avions WHERE categorieAvion = 'Classe Affaire';
GO;

SELECT (SELECT nombrePlace - count(idTicket)) AS 'nombrePlace Disponible' FROM avions INNER JOIN vols ON avions.idAvion = vols.idAvion INNER JOIN tickets ON vols.idVol = tickets.idVol WHERE idVol = 84;
GO;

-- Q7, 8 et 9 sont avancees par rapport a notre avancement du module !!

-- #####################################################

-- ################### MYSQL SYNTHAX ###################
-- #################### PHPMYADMIN #####################
CREATE DATABASE basevol;

USE basevol;

CREATE TABLE aeroport(
    idAeroport int AUTO_INCREMENT NOT NULL UNIQUE,
    nomAeroport VARCHAR(15) NOT NULL,
    CONSTRAINT PK_Aeroport PRIMARY KEY (idAeroport)
);

CREATE TABLE avions(
    idAvion int AUTO_INCREMENT NOT NULL UNIQUE,
    categorieAvion VARCHAR(15) NOT NULL,
    nomAvion VARCHAR(15) NOT NULL,
    nombrePlace int NOT NULL,
    photo TEXT NOT NULL,
    CONSTRAINT PK_Avions PRIMARY KEY (idAvion)
);

CREATE TABLE vols(
    idVol int AUTO_INCREMENT NOT NULL UNIQUE,
    aeroportDepart int NOT NULL,
    aeroportArrive int NOT NULL,
    dateDepart date NOT NULL,
    heureDepart int NOT NULL,
    idAvion int NOT NULL,
    CONSTRAINT PK_Vols PRIMARY KEY (idVol),
    CONSTRAINT FK_AeroportDT FOREIGN KEY (aeroportDepart) REFERENCES aeroport(idAeroport),
    CONSTRAINT FK_AeroportAv FOREIGN KEY (aeroportArrive) REFERENCES aeroport(idAeroport),
    CONSTRAINT FK_Avions FOREIGN KEY (idAvion) REFERENCES avions(idAvion)
);


CREATE TABLE tickets(
    idTicket int AUTO_INCREMENT NOT NULL UNIQUE,
    idVol int NOT NULL,
    prix float NOT NULL,
    numeroPlace int NOT NULL,
    CONSTRAINT PK_Tickets PRIMARY KEY (idTicket),
    CONSTRAINT FK_Tickets FOREIGN KEY (idVol) REFERENCES vols(idVol)
);

CREATE TABLE escales(
    idEscale int AUTO_INCREMENT NOT NULL UNIQUE,
    idVol int NOT NULL,
    idAeroport int NOT NULL,
    CONSTRAINT PK_Escale PRIMARY KEY (idEscale),
    CONSTRAINT FK_EscaleVol FOREIGN KEY (idVol) REFERENCES vols(idVol),
    CONSTRAINT FK_EscaleAeroport FOREIGN KEY (idAeroport) REFERENCES aeroport(idAeroport)
);
ALTER TABLE tickets
ADD CONSTRAINT Check_NumPlace CHECK (numeroPlace<400);
-- #####################################################