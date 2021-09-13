<?php
namespace model\dao;

use model\work\City;
use PDOStatement;
use PDO;

/**
 * @author apineau
 * @version 2021
 */
class CityDAO {
    protected static function bddToWork(array $bdd) {
        $id = $bdd['ID'];
        $name = $bdd['NAME'];
        $source = $bdd['SOURCE'];
        $description = $bdd['DESCRIPTION'];
        $oneCity = new City($id, $name, $source, $description);
        return $oneCity;
    }

    protected static function workToBdd(City $object, $region, PDOStatement $stmt) {
        $stmt->bindValue(':id', $object->getId());
        $stmt->bindValue(':name', $object->getName());
        $stmt->bindValue(':source', $object->getSource());
        $stmt->bindValue(':description', $object->getDescription());
        $stmt->bindValue(':region', $region);
    }

    public static function getAll() {
        $objects = array();
        $query = "SELECT * FROM Cities ORDER BY NAME";
        $stmt = Bdd::getPdo()->prepare($query);
        $ok = $stmt->execute();
        if ($ok) {
            while ($bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $objects[] = self::bddToWork($bdd);
            }
        }
        return $objects;
    }

    public static function getAllByRegion($region) {
        $objects = array();
        $query = "SELECT * FROM Cities WHERE region = :region ORDER BY NAME";
        $stmt = Bdd::getPdo()->prepare($query);
        $stmt->bindParam(':region', $region);
        $ok = $stmt->execute();
        if ($ok) {
            while ($bdd = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $objects[] = self::bddToWork($bdd);
            }
        }
        return $objects;
    }

    public static function getOneById($id) {
        $object = null;
        $query = "SELECT * FROM Cities WHERE ID = :id";
        $stmt = Bdd::getPdo()->prepare($query);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        if ($ok && $stmt->rowCount() > 0) {
            $object = self::bddToWork($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $object;
    }
    
    public static function insert(City $object) {
        $query = "INSERT INTO Cities VALUES (:id, :name, :source, :description, :region)";
        $stmt = Bdd::getPdo()->prepare($query);
        self::workToBdd($object, $stmt);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function update($id, City $object, $region) {
        $ok = false;
        $query = "UPDATE  Cities SET NAME=:name, SOURCE=:source,
           DESCRIPTION=:description, REGION=:region
           WHERE id =:id";
        $stmt = Bdd::getPdo()->prepare($query);
        self::workToBdd($object, $stmt);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        return ($ok && $stmt->rowCount() > 0);
    }

    public static function delete($id) {
        $ok = false;
        $query = "DELETE FROM Cities WHERE id = :id";
        $stmt = Bdd::getPdo()->prepare($query);
        $stmt->bindParam(':id', $id);
        $ok = $stmt->execute();
        $ok = $ok && ($stmt->rowCount() > 0);
        return $ok;
    }

    public static function isAnExistingId($id) {
        $query = "SELECT COUNT(*) FROM Cities WHERE id =:id";
        $stmt = Bdd::getPdo()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }
    
    
}