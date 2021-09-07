<?php

namespace vue\representations;

use vue\VueGenerique;
use modele\metier\Representation;
use modele\metier\Lieu;


/**
 * Copyright (c)
 * @author Rudy Balestrat
 * @version 2019.
 *
 */
class VueListeRepresentations extends VueGenerique
{
    /** @var array liste des représentations */
    private $lesRepresentations;
    /** @var la date de verification */
    private $laDate;


    public function __construct()
    {
        parent::__construct();
    }

    public function afficher()
    {
        include $this->getEntete();

        ?>
        <h1 style="text-align: center">Programme par jours</h1>
        <?php
        $this->laDate = 0;
        if ($_SESSION['role'] == 'Gestionnaire') { ?>
        <a href="index.php?controleur=representations&action=creer">Création d'une représentation</a>
        <br/><br/>
        <?php
        }
        if (count($this->lesRepresentations) != 0) {
            foreach ($this->lesRepresentations as $uneRepresentation) {
                if ($this->laDate != $uneRepresentation->getDate()) {
                    if ($this->laDate != 0) { ?> </table><br/> <?php } ?>
                    <strong><?= $uneRepresentation->getDate() ?></strong><br>
                    <table width="45%" cellspacing="0" cellpadding="0" class="tabQuadrille">
                    <!--AFFICHAGE DE LA LIGNE D'EN-TÊTE-->
                    <tr class="enTeteTabQuad">
                        <td width="33%">Lieu</td>
                        <td width="35%">Groupe</td>
                        <td width="8%">Heure début</td>
                        <td width="8%">Heure fin</td>
                        <?php
                        if ($_SESSION['role'] == 'Gestionnaire') {
                            ?>
                            <td width="8%">Modification</td>
                            <td width="8%">Suppression</td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                <tr class="ligneTabQuad">
                    <td><?= $uneRepresentation->getLieu()->getNom() ?></td>
                    <td><?= $uneRepresentation->getGroupe()->getNom() ?></td>
                    <td><?= $uneRepresentation->getHeureDebut() ?></td>
                    <td><?= $uneRepresentation->getHeureFin() ?></td>
                    <?php
                    if ($_SESSION['role'] == 'Gestionnaire') {
                        ?>
                        <td>
                            <a href="index.php?controleur=representations&action=modifier&id=<?= $uneRepresentation->getId() ?>">Modifier</a>
                        </td>
                        <td>
                            <a href="index.php?controleur=representations&action=supprimer&id=<?= $uneRepresentation->getId() ?>">Supprimer</a>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
                $this->laDate = $uneRepresentation->getDate();
            }
            include $this->getPied();
        }
    }

    public
    function setLesRepresentations(array $lesRepresentations)
    {
        $this->lesRepresentations = $lesRepresentations;
    }

}