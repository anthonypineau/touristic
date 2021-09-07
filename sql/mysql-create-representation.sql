-- noinspection SqlDialectInspection

DROP TABLE IF EXISTS `Representation`;

CREATE TABLE Representation (
idRepresentation INT(11) NOT NULL ,
idLieu INT(11) NOT NULL ,
idGroupe CHAR(4) NOT NULL ,
dateRepresentation DATE NOT NULL,
heureDebut TIME NOT NULL ,
heureFin TIME NOT NULL,

PRIMARY KEY (idRepresentation),
constraint fk1_Representation foreign key(idLieu) references Lieu(idLieu) ON DELETE CASCADE ON UPDATE CASCADE,
constraint fk2_Representation foreign key(idGroupe) references Groupe(id) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = INNODB;