<?php
/**
 * Copyright (c)
 *  @author Pineau Anthony
 *  @version 2019.
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RepresentationDAO : test</title>
    </head>

    <body>

        <?php

        use modele\metier\Representation;
        use modele\metier\Groupe;
        use modele\metier\Lieu;
        use modele\dao\RepresentationDAO;
        use modele\dao\Bdd;
        use controleur\Session;

require_once __DIR__ . '/../../includes/autoload.inc.php';

        $id = '1';
        Session::demarrer();
        Bdd::connecter();

        echo "<h2>Test RepresentationDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getOneById</h3>";
        try {
            $objet = RepresentationDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- Test getAll</h3>";
        try {
            $lesObjets = RepresentationDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = '999';
            $groupe = new Groupe("g001","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
            $lieu = new Lieu(1,"Les beaux bois","26 rue des bois",1500);
            $objet1 = new Representation($id, $lieu, $groupe, '2019/10/15', '14:00', '18:00');
            $ok = RepresentationDAO::insert($objet1);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = RepresentationDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de l'insertion ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°3-bis
        echo "<h3>3-bis insert déjà présent</h3>";
        try {
            $id = '999';
            $groupe = new Groupe("g999","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
            $lieu = new Lieu(5,"Les beaux bois","26 rue des bois",1500);          
            $objet2 = new Representation($id, $lieu, $groupe, '2019/10/15', '14:00', '18:00');
            $ok = RepresentationDAO::insert($objet2);
            if ($ok) {
                echo "<h4>*** échec du test : l'insertion ne devrait pas réussir  ***</h4>";
                $objetLu = Bdd::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>ooo réussite du test : l'insertion a logiquement échoué ooo</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>ooo réussite du test : la requête d'insertion a logiquement échoué ooo</h4>" . $e->getMessage();
        }

        // Test n°4
        echo "<h3>4- update</h3>";
        try {
            $objet1->setHeureDebut('13:00');
            $objet1->setHeureFin('15:00');
            $ok = RepresentationDAO::update($id, $objet1);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = RepresentationDAO::getOneById($id);
                var_dump($objetLu);
            } else {
                echo "<h4>*** échec de la mise à jour ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°5
        echo "<h3>5- delete</h3>";
        try {
            $ok = RepresentationDAO::delete($id);
            if ($ok) {
                echo "<h4>ooo réussite de la suppression ooo</h4>";
            } else {
                echo "<h4>*** échec de la suppression ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°6
        echo "<h3>6- isAnExistingId</h3>";
        try {
            $id = "2";
            $ok = RepresentationDAO::isAnExistingId($id);
//            $ok = $ok && !LieuDAO::isAnExistingId('AZERTY');
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°7
        echo "<h3>7- isAnExistingRep</h3>";
        try {
            $lieu = new Lieu(1,"SALLE DU PANIER FLEURI","26 rue des bois",1500);
            $groupe = new Groupe("g041","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
            $rep = new Representation(1,$lieu, $groupe, "2017-07-11","20:00","22:00");
            $ok = RepresentationDAO::isAnExistingRep(false,$rep);
//            $ok = $ok && !LieuDAO::isAnExistingId('AZERTY');
            if ($ok) {
                echo "<h4>La lieu est déjà utilisé pour ces horaires</h4>";
            } else {
                echo "<h4>La lieu est disponible</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        // Test n°8
        echo "<h3>8- isAnExistingGrp</h3>";
        try {
            $groupe = new Groupe("g041","les Joyeux Turlurons","général Alcazar","Tapiocapolis" ,25,"San Theodoros","N");
            $ok = RepresentationDAO::isAnExistingGrp(false,$groupe);
//            $ok = $ok && !LieuDAO::isAnExistingId('AZERTY');
            if ($ok) {
                echo "<h4>Le groupe a déjà une représentation</h4>";
            } else {
                echo "<h4>Le groupe n'a pas de représentation</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        Bdd::deconnecter();
        Session::arreter();
        ?>


    </body>
</html>