-- 
-- Base de données :  `touristic`
-- MySQL
--
 
DROP TABLE IF EXISTS `Users`;

create table Users
(id int not null auto_increment,
username varchar(45) not null,
password varchar(150) not null,
constraint pk_Users primary key(id))
ENGINE=INNODB;

