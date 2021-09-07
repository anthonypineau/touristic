<?php
/**
 * Description Page à afficher en cas de demande d'action non autorisée (utilisateur non connecté)
 * @author apineau
 * @version 2019
 */
namespace vue\accueil;

use vue\VueGenerique;

class VueActionRoleNonAutorisee extends VueGenerique {

    public function __construct() {
        parent::__construct();
    }

    public function afficher() {
        include $this->getEntete();
        ?>
        <br>
        <h2>Vous n'avez pas les droits</h2>
        <?php
        include $this->getPied();
    }

}
