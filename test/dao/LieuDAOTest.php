<?php
/**
 * Copyright (c)
 *  @author Rudy Balestrat
 *  @version 2019.
 *
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>LieuDAO : test</title>
    </head>

    <body>

        <?php

        use modele\metier\Lieu;
        use modele\dao\LieuDAO;
        use modele\dao\Bdd;
        use controleur\Session;

require_once __DIR__ . '/../../includes/autoload.inc.php';

        $id = '1';
        Session::demarrer();
        Bdd::connecter();

        echo "<h2>Test LieuDAO</h2>";

        // Test n°1
        echo "<h3>1- Test getOneById</h3>";
        try {
            $objet = LieuDAO::getOneById($id);
            var_dump($objet);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°2
        echo "<h3>2- Test getAll</h3>";
        try {
            $lesObjets = LieuDAO::getAll();
            var_dump($lesObjets);
        } catch (Exception $ex) {
            echo "<h4>*** échec de la requête ***</h4>" . $ex->getMessage();
        }

        // Test n°3
        echo "<h3>3- insert</h3>";
        try {
            $id = '999';
            $objet1 = new Lieu($id, 'Test du nom de lieu', 'Test de l adresse du lieu', '150');
            $ok = LieuDAO::insert($objet1);
            if ($ok) {
                echo "<h4>ooo réussite de l'insertion ooo</h4>";
                $objetLu = LieuDAO::getOneById($id);
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
            $objet2 = new Lieu($id, 'Test 2 du nom de lieu', 'Test 2 de l adresse du lieu', '1502');
            $ok = LieuDAO::insert($objet2);
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
            $objet1->setNom('Le test du nom update');
            $objet1->setCapAcl(300);
            $ok = LieuDAO::update($id, $objet1);
            if ($ok) {
                echo "<h4>ooo réussite de la mise à jour ooo</h4>";
                $objetLu = LieuDAO::getOneById($id);
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
            $ok = LieuDAO::delete($id);
//            $ok = GroupeDAO::delete("xxx");
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
            $ok = LieuDAO::isAnExistingId($id);
            $ok = $ok && !LieuDAO::isAnExistingId('AZERTY');
            if ($ok) {
                echo "<h4>ooo test réussi ooo</h4>";
            } else {
                echo "<h4>*** échec du test ***</h4>";
            }
        } catch (Exception $e) {
            echo "<h4>*** échec de la requête ***</h4>" . $e->getMessage();
        }

        Bdd::deconnecter();
        Session::arreter();
        ?>


    </body>
</html>
