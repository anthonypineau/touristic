-- noinspection SqlNoDataSourceInspectionForFile

-- noinspection SqlDialectInspectionForFile

USE `festival`;

DROP TABLE IF EXISTS `Lieu`;

CREATE TABLE Lieu (
idLieu INT(11) NOT NULL ,
nomLieu TEXT NOT NULL ,
adrLieu TEXT NOT NULL ,
capAccueil INT(11) NOT NULL ,
PRIMARY KEY (idLieu)) ENGINE = INNODB;