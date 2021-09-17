-- 
-- Base de données :  `touristic`
-- MySQL
--

DROP TABLE IF EXISTS `Users`;
DROP TABLE IF EXISTS `Regions`;
DROP TABLE IF EXISTS `Cities`;

create table Users(
id int not null auto_increment,
username varchar(45) not null,
password varchar(150) not null,
constraint pk_Users primary key(id))
ENGINE=INNODB;

create table Regions(
id char(3) not null,
name varchar(100) not null,
description text not null,
description_en text not null,
constraint pk_Regions primary key(id))
ENGINE=INNODB;

create table Cities(
id int not null auto_increment,
name varchar(100) not null,
source varchar(250) not null,
description text not null,
region char(3) not null,
constraint pk_Cities primary key(id),
constraint fk1_Cities foreign key(region) references Regions(id) 
ON DELETE CASCADE ON UPDATE CASCADE)
ENGINE=INNODB;