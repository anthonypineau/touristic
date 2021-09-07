<?php

namespace vue\representations;

use modele\metier\Groupe;
use modele\metier\Lieu;
use modele\metier\Representation;
use vue\VueGenerique;

/**
 * Copyright (c)
 * @author Rudy Balestrat
 * @version 2019.
 *
 */
class VueSaisieRepresentation extends VueGenerique
{

    /** @var Representation representation à afficher */
    private $uneRepresentation;

    /** @var Lieu les lieux à afficher */
    private $lesLieux;

    /** @var Groupe les groupes à afficher */
    private $lesGroupes;

    /** @var string ="creer" ou = "modifier" en fonction de l'utilisation du formulaire */
    private $actionRecue;

    /** @var string ="validerCreer" ou = "validerModifier" en fonction de l'utilisation du formulaire */
    private $actionAEnvoyer;

    /** @var string à afficher en tête du tableau */
    private $message;

    public function __construct()
    {
        parent::__construct();
    }

    public function afficher()
    {
        include $this->getEntete();
        ?>
        <form method="POST" action="index.php?controleur=representations&action=<?= $this->actionAEnvoyer ?>">
            <br>
            <table width="85%" cellspacing="0" cellpadding="0" class="tabNonQuadrille">

                <tr class="enTeteTabNonQuad">
                    <td colspan="3"><strong><?= $this->message ?></strong></td>
                </tr>
                <?php
                // En cas de création, l'id est accessible à la saisie
                if ($this->actionRecue == "creer") {
                    // On a le souci de ré-afficher l'id tel qu'il a été saisi
                    ?>
                    <tr class="ligneTabNonQuad">
                        <td> Id*: </td>
                        <td><input type="number" value="<?= $this->uneRepresentation->getId() ?>" name="id" size ="10" maxlength="8"></td>
                    </tr>
                    <?php
                } else {
                    // sinon l'id est dans un champ caché
                    ?>
                    <tr>
                        <td><input type="hidden" value="<?= $this->uneRepresentation->getId(); ?>" name="id"></td>
                    </tr>
                    <?php
                }
                ?>

                <tr class="ligneTabNonQuad">
                    <td> Lieu*:</td>
                    <td>
                        <select name="lieu" id="lieu">
                            <?php
                            foreach ($this->lesLieux as $unLieu){ ?>
                                <option value="<?= $unLieu->getId()?>"
                                    <?php if($this->uneRepresentation->getLieu()->getId()==$unLieu->getId()){ ?> selected <?php }?>><?= $unLieu->getNom()?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Groupe*:</td>
                    <td>
                        <select name="groupe" id="groupe">
                            <?php
                            foreach ($this->lesGroupes as $unGroupe){ ?>
                                <option value="<?= $unGroupe->getId()?>"
                                    <?php if($this->uneRepresentation->getGroupe()->getId()==$unGroupe->getId()){ ?> selected <?php }?>><?= $unGroupe->getNom()?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Date*:</td>
                    <td><input type="date" value="<?= $this->uneRepresentation->getDate() ?>" name="laDate"></td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Heure debut*:</td>
                    <td><input type="time" value="<?= $this->uneRepresentation->getHeureDebut() ?>" name="hrDb"
                               min="09:00" max="23:00"></td>
                </tr>
                <tr class="ligneTabNonQuad">
                    <td> Heure fin*:</td>
                    <td><input type="time" value="<?= $this->uneRepresentation->getHeureFin() ?>" name="hrFn"
                               min="10:00" max="24:00"></td>
                </tr>
            </table>

            <table align="center" cellspacing="15" cellpadding="0">
                <tr>
                    <td align="right"><input type="submit" value="Valider" name="valider">
                    </td>
                    <td align="left"><input type="reset" value="Annuler" name="annuler">
                    </td>
                </tr>
            </table>
            <a href="index.php?controleur=representations&action=consulter">Retour</a>
        </form>
        <?php
        include $this->getPied();
    }

    public function setUneRepresentation(Representation $uneRepresentation)
    {
        $this->uneRepresentation = $uneRepresentation;
    }


    public function setActionRecue(string $action)
    {
        $this->actionRecue = $action;
    }

    public function setActionAEnvoyer(string $action)
    {
        $this->actionAEnvoyer = $action;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @param Lieu $lesLieux
     */
    public function setLesLieux(array $lesLieux)
    {
        $this->lesLieux = $lesLieux;
    }

    /**
     * @param Groupe $lesGroupes
     */
    public function setLesGroupes(array $lesGroupes)
    {
        $this->lesGroupes = $lesGroupes;
    }



}