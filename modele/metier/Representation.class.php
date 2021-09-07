<?php

namespace modele\metier;

class Representation{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var Lieu
     */
    private $lieu;
    
    /**
     * @var Groupe
     */
    private $groupe;
    
    /**
     * @var string
     */
    private $date;
    
    /**
     * @var string
     */
    private $heureDebut;
    
    /**
     * @var string
     */
    private $heureFin;
    
    /**
     * Representation constructor
     * @param int $id
     * @param Lieu $lieu
     * @param Groupe $groupe
     * @param string $date
     * @param string $heureDebut
     * @param string $heureFin
     */
    public function __construct(int $id, Lieu $lieu, Groupe $groupe, string $date, string $heureDebut, string $heureFin){
        $this->id = $id;
        $this->lieu = $lieu;
        $this->groupe = $groupe;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
    }
    
    //ACCESSEURS ET MUTATEURS
    
    function getId() : int {
        return $this->id;
    }

    function getLieu(): Lieu {
        return $this->lieu;
    }

    function getGroupe(): Groupe {
        return $this->groupe;
    }

    function getDate() : string {
        return $this->date;
    }

    function getHeureDebut() : string {
        return $this->heureDebut;
    }

    function getHeureFin() : string {
        return $this->heureFin;
    }

    function setId($id) : void {
        $this->id = $id;
    }

    function setLieu(Lieu $lieu) : void {
        $this->lieu = $lieu;
    }

    function setGroupe(Groupe $groupe) : void {
        $this->groupe = $groupe;
    }

    function setDate($date) : void {
        $this->date = $date;
    }

    function setHeureDebut($heureDebut) : void {
        $this->heureDebut = $heureDebut;
    }

    function setHeureFin($heureFin) : void {
        $this->heureFin = $heureFin;
    }
    
}