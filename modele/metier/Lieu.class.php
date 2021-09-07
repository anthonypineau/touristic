<?php

namespace modele\metier;

class Lieu {
    /**
    * @var int
    */
    private $id;
    /**
     * @var string
     */
    private $nom;
    /**
     * @var string
     */
    private $adr;
    /**
     * @var int
     */
    private $capAcl;

    /**
     * Lieu constructor.
     * @param int $id
     * @param string $nom
     * @param string $adr
     * @param int $capAcl
     */
    public function __construct(int $id, string $nom, string $adr, int $capAcl)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->adr = $adr;
        $this->capAcl = $capAcl;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getAdr(): string
    {
        return $this->adr;
    }

    /**
     * @param string $adr
     */
    public function setAdr(string $adr): void
    {
        $this->adr = $adr;
    }

    /**
     * @return int
     */
    public function getCapAcl(): int
    {
        return $this->capAcl;
    }

    /**
     * @param int $capAcl
     */
    public function setCapAcl(int $capAcl): void
    {
        $this->capAcl = $capAcl;
    }


}