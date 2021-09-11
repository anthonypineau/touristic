<?php

/**
 * @author apineau
 * @version 2021
 */
namespace controller;

use view\GenericView;

abstract class GenericController {

    protected $view;

    public abstract function default();

    protected function authorizedView() {
        $this->view->setIsLinksActive(true);
        $this->view->setIsConnected(true);
        $connectedUser = AuthentifiedSession::getUser();
        $this->view->setIdentity($connectedUser->getUsername());
    }

    protected function nonAuthorizedView() {
        $this->view->setIsLinksActive(false);
        $this->view->setIsConnected(false);
        $this->view->setIdentity("");
    }

    public function setView(GenericView $view) {
        $this->view = $view;
    }

    function __call($name, $arguments) {
        throw new \Exception("Fonctionnalité manquante :$name:");
    }
}