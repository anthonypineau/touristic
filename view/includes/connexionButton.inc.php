<?php
/**
 * @author apineau
 * @version 2021
 */

if (!$this->getIsConnected()) {
    ?>
    <div id="header_button" >
        <form id="frmIdentification" method="POST" action="index.php?controller=authentification&action=saisirIdentification">
            <input type="submit" value="Se connecter"/>
        </form>
    </div>
    <?php
} else {
    ?>
    <div id="header_button" >
        <form id="frmIdentification" method="POST" action="index.php?controller=authentification&action=seDeconnecter">
            <input type="submit" value="Se déconnecter"/>
        </form>
    </div>
    <div id="header_identity"><?= $this->getIdentity() ?></div>
    <?php
}
