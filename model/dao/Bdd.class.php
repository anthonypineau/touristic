<?php
/**
 * @author apineau
 * @version 2021
 */
namespace model\dao;

use \PDO;
use \PDOException;
use controller\ParametersHandling;

class Bdd {
    private static $pdo = null;

    public static function connect()  {
        if (is_null(self::$pdo)) {
            try {
                ParametersHandling::initialize();
                $pdo_options = array();
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
                $pdo_options[PDO::ATTR_CASE] = PDO::CASE_UPPER;
                self::$pdo = new PDO(
                    ParametersHandling::get("dsn").ParametersHandling::get("bdd"),
                    ParametersHandling::get("login"), ParametersHandling::get("mdp"),
                    $pdo_options
                );
                
            } catch (PDOException $e) {
                echo "ERREUR : " . $e->getMessage();
                die();
            }
        }
        return self::$pdo;
    }

    public static function disconnect() {
        self::$pdo = null;
    }

    /**
     * Accesseur
     * @return PDO objet d'accès à la BDD ou bien null
     */
    public static function getPdo()  {
        return self::$pdo;
    }

}
