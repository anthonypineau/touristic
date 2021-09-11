<?php
/**
 * @author apineau
 * @version 2021
 */
use controller\ParametersHandling;
use controller\Session;
use controller\AuthentifiedSession;
//use \Exception;
use controller\ErrorsHandling;

require_once __DIR__ . "/includes/autoload.inc.php";

Session::start();
// lecture des paramètres de l'application
ParametersHandling::initialize();
//include GestionParametres::racine() . "includes/fonctionsUtilitaires.inc.php";
//include GestionParametres::racine() . "includes/fonctionsDatesTimes.inc.php";
//include "includes/utilFunctions.inc.php";
//include "includes/dateFunctions.inc.php";

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = 'home';
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'default';
}

if (!AuthentifiedSession::isConnected() && $controller != 'home' && $controller != 'authentification') {
    $controller = 'home';
    $action = 'refuse';
}

try {
    $controllerClass = "controller\\" . ucfirst($controller) . "Controller";
    $ctrl = new $controllerClass();
    $ctrl->$action();
} catch (\Exception $e) {
    ErrorsHandling::ajouter("Module indisponible :$controller:- " . $e->getMessage());
    header("Location: index.php");
}


