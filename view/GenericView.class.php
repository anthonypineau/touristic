<?php
namespace view;
use controller\ParametersHandling;
/**
 * @author apineau
 * @version 2021
 */
abstract class GenericView {
    private $title;

    private $head;

    private $middle;

    private $footer;

    private $isLinksActive;

    private $isConnected;
    
    private $identiy;
    
    public function __construct() {
        $this->setTitle('Touristic');
        $this->setHead(ParametersHandling::root() . 'view/includes/head.inc.php');
        $this->setFooter(ParametersHandling::root() . 'view/includes/footer.inc.php');
    }

    public abstract function display();

    // ACCESSEURS ET MUTATEURS
    function getTitle(): string {
        return $this->title;
    }

    function getHead(): string {
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

    function setHead(string $header) {
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
