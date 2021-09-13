-- 
-- Base de données :  `touristic`
-- MySQL
--

INSERT INTO Users (username, password) VALUES ("admin", "21232f297a57a5a743894a0e4a801fc3");

INSERT INTO Regions(id, name) VALUES ("ARA", "Auvergne-Rhône-Alpes");
INSERT INTO Regions(id, name) VALUES ("BFC", "Bourgogne-Franche-Comté");
INSERT INTO Regions(id, name) VALUES ("BRE", "Bretagne");
INSERT INTO Regions(id, name) VALUES ("CVL", "Centre-Val de Loire");
INSERT INTO Regions(id, name) VALUES ("COR", "Corse");
INSERT INTO Regions(id, name) VALUES ("GES", "Grand Est");
INSERT INTO Regions(id, name) VALUES ("HDF", "Hauts-de-France");
INSERT INTO Regions(id, name) VALUES ("IDF", "Île-de-France");
INSERT INTO Regions(id, name) VALUES ("NOR", "Normandie");
INSERT INTO Regions(id, name) VALUES ("NAQ", "Nouvelle-Aquitaine");
INSERT INTO Regions(id, name) VALUES ("OCC", "Occitanie");
INSERT INTO Regions(id, name) VALUES ("PDL", "Pays de la Loire");
INSERT INTO Regions(id, name) VALUES ("PAC", "Provence-Alpes-Côte d'Azur");

INSERT INTO Cities(name, source, description, region) VALUES ("Angers", "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.qbksjUAP5XReFZC920LqQAHaEK%26pid%3DApi&f=1", "La belle ville d'Angers", "PDL");
INSERT INTO Cities(name, source, description, region) VALUES ("Nantes", "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.mr8OP5HQfoOnL690-iD_VwExDM%26pid%3DApi&f=1", "La belle ville de Nantes", "PDL");
INSERT INTO Cities(name, source, description, region) VALUES ("Rennes", "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%3Fid%3DOIP.3vxJSt3PntYUGRPd0R_bLQHaE7%26pid%3DApi&f=1", "La belle ville de Rennes", "BRE");
INSERT INTO Cities(name, source, description, region) VALUES ("Brest", "https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%3Fid%3DOIP.ird7h8SSgIADaQlo8FINwAHaDt%26pid%3DApi&f=1", "La belle ville de Brest", "BRE");
INSERT INTO Cities(name, source, description, region) VALUES ("", "", "", "");
INSERT INTO Cities(name, source, description, region) VALUES ("", "", "", "");
INSERT INTO Cities(name, source, description, region) VALUES ("", "", "", "");
INSERT INTO Cities(name, source, description, region) VALUES ("", "", "", "");
INSERT INTO Cities(name, source, description, region) VALUES ("", "", "", "");


