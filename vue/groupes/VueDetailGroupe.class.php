<?php


namespace vue\groupes;

use vue\VueGenerique;
use modele\metier\Groupe;

/**
 * Description Page de consultation d'un groupe donné
 * @author apineau
 * @version 2019
 */
class VueDetailGroupe extends VueGenerique {

    /** @var Groupe identificateur du groupe à afficher */
    private $unGroupe;

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();

        ?>
        <br>
        <table width='60%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
            <tr class='enTeteTabNonQuad'>
                <td colspan='3'><strong><?= $this->unGroupe->getNom() ?></strong></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td  width='20%'> Id : </td>
                <td><?= $this->unGroupe->getId() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Nom : </td>
                <td><?= $this->unGroupe->getNom() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Identite : </td>
                <td><?= $this->unGroupe->getIdentite() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Adresse : </td>
                <td><?= $this->unGroupe->getAdresse() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Nombres de personnes : </td>
                <td><?= $this->unGroupe->getNbPers() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Pays : </td>
                <td><?= $this->unGroupe->getNomPays() ?></td>
            </tr>
            <tr class='ligneTabNonQuad'>
                <td> Hebergement : </td>
                <td><?= $this->unGroupe->getHebergement() ?></td>
            </tr>
        </table>
        <br>
        <a href='index.php?controleur=groupes&action=liste'>Retour</a>
        <?php
        include $this->getPied();
    }

    function setUnGroupe(Groupe $unGroupe) {
        $this->unGroupe = $unGroupe;
    }


}
