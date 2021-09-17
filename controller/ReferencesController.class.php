<?php
/**
 * @author apineau
 * @version 2021
 */

namespace controller;

use view\references\ReferencesView;

class ReferencesController extends GenericController {
    function default() {
        $this->view = new ReferencesView();
        $this->view->setTitle("References");
        if (AuthentifiedSession::isConnected()) {
            parent::authorizedView();
        }else{
            parent::nonAuthorizedView();
        }
        $this->view->display();
    }
}
