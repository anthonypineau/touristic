<?php
namespace modele\metier;

/**
 * Description of User
 *
 * @author apineau
 * @version 2021
 */
class User {
    private $id;
    private $username;
    private $password;
    
    function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }
    public function __toString() {
        return get_class($this). "{ id=". $this->id . " - username=". $this->username . " password=". $this->password "}";
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->civilite;
    }

    function getPassword() {
        return $this->nom;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }
}
