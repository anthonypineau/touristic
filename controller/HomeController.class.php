<?php
/**
 * Contrôleur de la page d'accueil
 * @author apineau
 * @version 2021
 */

namespace controller;

use view\home\HomeView;
use view\home\HomeViewNonAuthorized;

class HomeController extends GenericController {
    function default() {
        $this->view = new HomeView();
        $this->view->setTitle("Touristic");
        if (AuthentifiedSession::isConnected()) {
            parent::authorizedView();
        }else{
            parent::nonAuthorizedView();
        }
        $this->view->display();

    }
    
    function refuse() {
        $this->view = new HomeViewNonAuthorized();
        $this->view->setTitle("Touristic");
        parent::nonAuthorizedView();
        $this->view->display();
    }
}
