<?php
/**
 * Copyright (c)
 * @author Pineau Anthony
 * @version 2019.
 *
 */

namespace modele\dao;

use modele\metier\Representation;
use modele\metier\Lieu;
use modele\metier\Groupe;
use modele\dao\LieuDAO;
use modele\dao\GroupeDAO;
use PDO;
use PDOStatement;

class RepresentationDAO
{

    /**
     * Instancier un objet de la classe Representation à partir d'un enregistrement de la table representation
     * @param array $enreg
     * @return Representation
     */
    protected static function enregVersMetier(array $enreg)
    {
        $id = $enreg['IDREPRESENTATION'];
        $lieu = LieuDAO::getOneById($enreg['IDLIEU']);
        $groupe = GroupeDAO::getOneById($enreg['IDGROUPE']);
        $date = $enreg['DATEREPRESENTATION'];
        $heureDebut = $enreg['HEUREDEBUT'];
        $heureFin = $enreg['HEUREFIN'];
        $uneRepresentation = new Representation($id, $lieu, $groupe, $date, $heureDebut, $heureFin);

        return $uneRepresentation;
    }

    /**
     * Valorise les paramètres d'une requête préparée avec l'état d'un objet Representation
     * @param Representation $objet Metier une representation
     * @param PDOStatement $stmt requête préparée
     */
    protected static function metierVersEnreg(Representation $objetMetier, PDOStatement $stmt)
    {
        // On utilise bindValue plutôt que bindParam pour éviter des variables intermédiaires
        // Note : bindParam requiert une référence de variable en paramètre n°2 ;
        // avec bindParam, la valeur affectée à la requête évoluerait avec celle de la variable sans
        // qu'il soit besoin de refaire un appel explicite à bindParam

        $stmt->bindValue(':idRepresentation', $objetMetier->getId());
        $stmt->bindValue(':idLieu', $objetMetier->getLieu()->getId());
        $stmt->bindValue(':idGroupe', $objetMetier->getGroupe()->getId());
        $stmt->bindValue(':dateRepresentation', $objetMetier->getDate());
        $stmt->bindValue(':heureDebut', $objetMetier->getHeureDebut());
        $stmt->bindValue(':heureFin', $objetMetier->getHeureFin());
    }

    /**
     * Retourne la liste de tous les representations
     * @return array tableau d'objets de type Representation
     */
    public static function getAll()
    {
        $lesObjets = array();
        $requete = "SELECT * FROM Representation ORDER BY dateRepresentation,idLieu";
        $stmt = Bdd::getPdo()->prepare($requete);
        $ok = $stmt->execute();
        if ($ok) {
            // Tant qu'il y a des enregistrements dans la table
            while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //ajoute une nouvelle representation au tableau
                $lesObjets[] = self::enregVersMetier($enreg);
            }
        }
        return $lesObjets;
    }

    /**
     * Recherche un lieu selon la valeur de son identifiant
     * @param string $id
     * @return Representation le groupe trouvé ; null sinon
     */
    public static function getOneById($id)
    {
        $objetConstruit = null;
        $requete = "SELECT * FROM Representation WHERE idRepresentation = :id";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }

    /**
     * Insérer une nouvelle representation dans la table à partir de l'état d'un objet métier
     * @param Representation $objet objet métier à insérer
     * @return boolean =FALSE si l'opération échoue
     */
    public static function insert(Representation $objet)
    {
        $requete = "INSERT INTO Representation VALUES (:idRepresentation, :idLieu, :idGroupe, :dateRepresentation, :heureDebut, :heureFin)";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Mettre à jour enregistrement dans la table à partir de l'état d'un objet métier
     * @param string identifiant de l'enregistrement à mettre à jour
     * @param Representation $objet objet métier à mettre à jour
     * @return boolean =FALSE si l'opérationn échoue
     */
    public static function update($id, Representation $objet)
    {
        $ok = false;
        $requete = "UPDATE  Representation SET idLieu =:idLieu, idGroupe =:idGroupe,
           dateRepresentation =:dateRepresentation, heureDebut =:heureDebut, heureFin =:heureFin
           WHERE idRepresentation =:idRepresentation";
        $stmt = Bdd::getPdo()->prepare($requete);
        self::metierVersEnreg($objet, $stmt);
        $stmt->bindParam(':idRepresentation', $id);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    /**
     * Détruire un enregistrement de la table representation d'après son identifiant
     * @param string identifiant de l'enregistrement à détruire
     * @return boolean =TRUE si l'enregistrement est détruit, =FALSE si l'opération échoue
     */
    public static function delete($id)
    {
        $ok = false;
        $requete = "DELETE FROM Representation WHERE idRepresentation = :idRepresentation";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idRepresentation', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    /**
     * Permet de vérifier s'il existe ou non une representation ayant déjà le même identifiant dans la BD
     * @param string $id identifiant de la representation à tester
     * @return boolean =true si l'id existe déjà, =false sinon
     */
    public static function isAnExistingId($id)
    {
        $requete = "SELECT COUNT(*) FROM Representation WHERE idRepresentation =:idRepresentation";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':idRepresentation', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }

    /**
     * Permet de vérifier si le lieu de la représentation est déjà sur une autre représentation à la même heure
     * @param bool $creation savoir si c'est une nouvelle représentation ou un modification
     * @param Representation $uneRep l'objet représentation
     * @return boolean =true si la lieu est déjà utilisé, =false sinon
     */
    public static function isAnExistingRep($creation, $uneRep)
    {
        // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
        // on vérifie la non existence d'un autre établissement (id!='$id') portant
        // le même nom
        $id = $uneRep->getId();
        $hrFn = $uneRep->getHeureFin();
        $hrDbt = $uneRep->getHeureDebut();
        $date = $uneRep->getDate();
        $idLieu = $uneRep->getLieu()->getId();
        if ($creation) {
            $requete = "SELECT COUNT(*) FROM Representation WHERE idLieu = :idlieu AND dateRepresentation = :dateRep AND (heureDebut >= :hrDbt AND heureDebut < :hrFn AND heureFin > :hrDbt AND heureFin <= :hrFn OR :hrDbt >= heureDebut AND :hrDbt < heureFin OR :hrFn > heureDebut AND :hrFn <= heureFin)";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':idlieu', $idLieu);
            $stmt->bindParam(':hrDbt', $hrDbt);
            $stmt->bindParam(':hrFn', $hrFn);
            $stmt->bindParam(':dateRep', $date);
            $stmt->execute();
        } else {
            $requete = "SELECT COUNT(*) FROM Representation WHERE idRepresentation <> :id AND idLieu = :idlieu AND dateRepresentation = :dateRep AND (heureDebut >= :hrDbt AND heureDebut < :hrFn AND heureFin > :hrDbt AND heureFin <= :hrFn OR :hrDbt >= heureDebut AND :hrDbt < heureFin OR :hrFn > heureDebut AND :hrFn <= heureFin)";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':idlieu', $idLieu);
            $stmt->bindParam(':hrDbt', $hrDbt);
            $stmt->bindParam(':hrFn', $hrFn);
            $stmt->bindParam(':dateRep', $date);
            $stmt->execute();
        }
        return $stmt->fetchColumn(0);
    }

    /**
     * Permet de vérifier si le groupe n'a pas déjà une représentation
     * @param bool $creation savoir si c'est une nouvelle représentation ou un modification
     * @param Groupe $groupe groupe de la représentation
     * @return boolean =true si la lieu est déjà utilisé, =false sinon
     */
    public static function isAnExistingGrp($creation, $groupe)
    {
        $ok = false;
        $idGrp = $groupe->getId();
        if ($creation) {
            $requete = "SELECT COUNT(*) FROM Representation WHERE idGroupe =:idgroupe";
            $stmt = Bdd::getPdo()->prepare($requete);
            $stmt->bindParam(':idgroupe', $idGrp);
            $stmt->execute();
            if ($stmt->fetchColumn(0)) {
                $ok = true;
            }
        }
        return $ok;
    }
}