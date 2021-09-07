<?php

namespace vue\representations;

use vue\VueGenerique;
use modele\metier\Representation;

/**
 * Copyright (c)
 * @author Rudy Balestrat
 * @version 2019.
 *
 */
class VueSupprimerRepresentation extends VueGenerique
{
    /** @var Representation identificateur de la représentation à afficher */
    private $uneRepresentation;

    public function __construct()
    {
        parent::__construct();
    }

    public function afficher()
    {
        include $this->getEntete();
        ?>
        <br>
        <center>Voulez-vous vraiment supprimer la représentation du
            groupe <?= $this->uneRepresentation->getGroupe()->getNom() ?> le <?= $this->uneRepresentation->getDate() ?>
            entre <?= $this->uneRepresentation->getHeureDebut() ?> et <?= $this->uneRepresentation->getHeureFin() ?> ?
            <h3><br>
                <a href="index.php?controleur=representations&action=validerSupprimer&id=<?= $this->uneRepresentation->getId() ?>">Oui</a>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <a href="index.php?controleur=representations">Non</a></h3>
        </center>
        <?php
        include $this->getPied();
    }

    function setUneRepresentation(Representation $uneRepresentation)
    {
        $this->uneRepresentation = $uneRepresentation;
    }
}