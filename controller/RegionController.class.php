<?php
/**
 * Contrôleur de la page d'accueil
 * @author apineau
 * @version 2021
 */

namespace controller;

use view\region\RegionView;
use model\dao\Bdd;
use model\dao\RegionDAO;
use model\work\Region;

class RegionController extends GenericController {
    function default() {
        $this->view = new RegionView();
        $idRegion = strtoupper($_GET["id"]);
        Bdd::connect();
        $region=RegionDAO::getOneById($idRegion);
        $this->view->setRegion($region);
        $this->view->setTitle($region->getName());
        if (AuthentifiedSession::isConnected()) {
            parent::authorizedView();
        }else{
            parent::nonAuthorizedView();
        }
        $this->view->display();
    }
}
