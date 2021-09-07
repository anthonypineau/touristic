<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Representation Test</title>
</head>
<body>
<?php
use modele\metier\Lieu;
use modele\metier\Groupe;
use modele\metier\Representation;
require_once __DIR__ . '/../../includes/autoload.inc.php';
echo "<h2>Test unitaire de la classe métier Representation</h2>";
$groupe = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
$lieu = new Lieu(5,"Les beaux bois","26 rue des bois",1500);
$representation = new Representation(1, $lieu, $groupe, "2019/10/15", "14:00", "18:00");
var_dump($representation);
?>
</body>
</html>