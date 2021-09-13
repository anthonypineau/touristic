<?php
namespace model\work;

/**
 * @author apineau
 * @version 2021
 */
class Region {
    private $id;
    private $name;
    private $cities;
    
    function __construct($id, $name, $cities) {
        $this->id = $id;
        $this->name = $name;
        $this->cities = $cities;
    }
    public function __toString() {
        return get_class($this). "{ id=". $this->id . " - name=". $this->name . " cities=". $this->cities . "}";
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getCities() {
        return $this->cities;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setCities($cities){
        $this->cities = $cities;
    }
}
