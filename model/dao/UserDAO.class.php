<?php
namespace modele\dao;

use modele\metier\User;
use PDO;

/**
 * Description of UserDAO
 * Classe métier  :  User
 * @author apineau
 * @version 2021
 */
class UsersDAO {
    /**
     * @param array $enreg
     * @return User objet métier obtenu
     */
    protected static function enregVersMetier(array $enreg) {
        $id = $enreg['ID'];
        $username = $enreg['USERNAME'];
        $password = $enreg['PASSWORD'];
        $objetMetier = new User($id, $username, $password);
        return $objetMetier;
    }
  /**
     * Recherche un utilisateur selon la valeur de son login
     * @param string $unLogin valeur de login recherchée
     * @return Utilisateur l'utilisateur trouvé ; null sinon
     */
    public static function getOneByLogin($username) {
        $objetConstruit = null;
        $requete = "SELECT * FROM users WHERE LOGIN = :login";
        $stmt = Bdd::getPdo()->prepare($requete);
        $stmt->bindParam(':login', $username);
        $ok = $stmt->execute();
        // attention, $ok = true pour un select ne retournant aucune ligne
        if ($ok && $stmt->rowCount() > 0) {
            $objetConstruit = self::enregVersMetier($stmt->fetch(PDO::FETCH_ASSOC));
        }
        return $objetConstruit;
    }
    
    
    
}
