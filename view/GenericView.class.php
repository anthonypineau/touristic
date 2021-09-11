<?php

namespace view;

use controller\ParametersHandling;

/**
 * Implémentation d'une classe vue pour ce projet
 * Toutes les vues en héritent
 * @author apineau
 * @version 2021
 */
abstract class GenericView {

    /** @var string titre de la vue (dans debut.inc.php) */
    private $title;

    /** @var string chemin d'accès vers le fichier d'inclusion pour l'entête  */
    private $header;

    /** @var string chemin d'accès vers le fichier d'inclusion pour la partie centrale */
    private $middle;

    /** @var string chemin d'accès vers le fichier d'inclusion pour le pied de page */
    private $footer;

    /** @var bool statut des liens des onglets ; =true => actif ; =false => inactif (dans debut.inc.php) */
    private $isLinksActive;

    /** @var bool un utilisateur est-il authentifié sur cette session */
    private $isConnected;
    
    /** @var string identité de l'utilisateur connecté (à afficher à coté du bouton) */
    private $identiy;
    
    public function __construct() {
        $this->setTitle('Touristic');
        $this->setHeader(ParametersHandling::root() . 'view/includes/debut.inc.php');
        $this->setFooter(ParametersHandling::root() . 'view/includes/fin.inc.php');
    }

    /**
     *  Afficher la vue signifie l'inclure au flux de sortie HTML
     */
    public abstract function display();

    // ACCESSEURS ET MUTATEURS
    function getTitle(): string {
        return $this->title;
    }

    function getHeader(): string {
        return $this->header;
    }

    function getMiddle(): string {
        return $this->$middle;
    }

    function getFooter(): string {
        return $this->footer;
    }

    function getIsLinksActive(): bool {
        return $this->isLinksActive;
    }

    public function getIsConnected() : bool {
        return $this->isConnected;
    }

    public function getIdentity() : string {
        return $this->identity;
    }

    function setTitle(string $title) {
        $this->title = $title;
    }

    function setHeader(string $header) {
        $this->header = $header;
    }

    function setMiddle(string $middle) {
        $this->middle = $middle;
    }

    function setFooter(string $footer) {
        $this->footer = $footer;
    }

    function setIsLinksActive(bool $isLinksActive) {
        $this->isLinksActive = $isLinksActive;
    }
    
    public function setIsConnected (bool $isConnected) {
        $this->isConnected = $isConnected;
    }

    public function setIdentity(string $identity) {
        $this->identity = $identity;
    }
}
