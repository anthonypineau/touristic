<?php
/**
 * Copyright (c)
 * @author Rudy Balestrat
 * @version 2019.
 *
 */

namespace controleur;

use modele\dao\GroupeDAO;
use modele\dao\LieuDAO;
use modele\dao\RepresentationDAO;
use modele\dao\Bdd;
use modele\metier\Groupe;
use modele\metier\Lieu;
use modele\metier\Representation;
use vue\representations\VueListeRepresentations;
use vue\representations\VueSaisieRepresentation;
use vue\representations\VueSupprimerRepresentation;

class CtrlRepresentations extends ControleurGenerique
{

    /** controleur= representations & action= defaut
     * Afficher la liste des representations      */
    public function defaut()
    {
        $this->consulter();
    }

    /** controleur= representation & action= consulter
     * Afficher la liste des offres d'hébergement       */
    function consulter()
    {
        $laVue = new VueListeRepresentations();
        $this->vue = $laVue;
        // La vue a besoin de la liste des établissments et de celle des types de chambres
        Bdd::connecter();
        $laVue->setLesRepresentations(RepresentationDAO::getAll());
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - représentation");
        $this->vue->afficher();
    }

    /** controleur= representations & action= modifier & id = identifiant de l'établissement visé
     * Modifier les offres d'hébergement proposées par un établissement  */
    function creer()
    {
        $laVue = new VueSaisieRepresentation();
        $this->vue = $laVue;
        // La vue a besoin :
        //  - de la représentation,
        //  - l'ensemble des lieux
        //  - l'ensemble des groupes
        Bdd::connecter();
        // En création, on affiche un formulaire vide
        /* @var Representation $uneRep */
        $lieu = new Lieu(0,"","",0);
        $groupe = new Groupe("","","","" ,0,"","");
        $uneRep = new Representation(0, $lieu, $groupe, "","00:00","00:00");
        $laVue->setUneRepresentation($uneRep);
        $laVue->setLesLieux(LieuDAO::getAll());
        $laVue->setLesGroupes(GroupeDAO::getAll());
        $laVue->setActionRecue("creer");
        $laVue->setActionAEnvoyer("validerCreer");
        $laVue->setMessage("Creer une représentation");
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - représentation");
        $this->vue->afficher();
    }

    /** controleur= representation & action= validerCreer
     * Afficher la liste des représentation      */
    public function validerCreer() {
        Bdd::connecter();
        $groupe = GroupeDAO::getOneById($_REQUEST['groupe']);
        $lieu = LieuDAO::getOneById((int)$_REQUEST['lieu']);
        /* @var Representation $uneRepresentation  : récupération du contenu du formulaire et instanciation d'une représentation */
        $uneRep= new Representation($_REQUEST['id'], $lieu , $groupe , $_REQUEST['laDate'] ,$_REQUEST['hrDb'], $_REQUEST['hrFn']);

        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesRep($uneRep, true);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour l'établissement
            $uneRep= new Representation($_REQUEST['id'], $lieu, $groupe , $_REQUEST['laDate'] ,$_REQUEST['hrDb'], $_REQUEST['hrFn']);
            RepresentationDAO::insert($uneRep);
            // revenir à la liste des représentations
            header("Location: index.php?controleur=representations&action=consulter");
        } else {
            // s'il y a des erreurs,
            // réafficher le formulaire de modification
            $laVue = new VueSaisieRepresentation();
            $this->vue = $laVue;
            $laVue->setUneRepresentation($uneRep);
            $laVue->setLesLieux(LieuDAO::getAll());
            $laVue->setLesGroupes(GroupeDAO::getAll());
            $laVue->setActionRecue("creer");
            $laVue->setActionAEnvoyer("validerCreer");
            $laVue->setMessage("Creer une représentation");
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - représentation");
            $this->vue->afficher();
        }
    }

    /** controleur= representations & action= modifier & id = identifiant de la représentation visé
     * Modifier les offres d'hébergement proposées par un représentation  */
    function modifier()
    {
        $laVue = new VueSaisieRepresentation();
        $this->vue = $laVue;
        // Lecture de l'id de l'établissement
        $idRep= $_GET['id'];
        // La vue a besoin :
        //  - de la représentation,
        //  - l'ensemble des lieux
        //  - l'ensemble des groupes
        Bdd::connecter();
        $laVue->setUneRepresentation(RepresentationDAO::getOneById($idRep));
        $laVue->setLesLieux(LieuDAO::getAll());
        $laVue->setLesGroupes(GroupeDAO::getAll());
        $laVue->setActionRecue("modifier");
        $laVue->setActionAEnvoyer("validerModifier");
        $laVue->setMessage("Modification représentation");
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - représentation");
        $this->vue->afficher();
    }

    /** controleur= representation & action= validerModifier
     * Afficher la liste des représentation      */
    public function validerModifier() {
        Bdd::connecter();
        $groupe = GroupeDAO::getOneById($_REQUEST['groupe']);
        $lieu = LieuDAO::getOneById((int)$_REQUEST['lieu']);
        /* @var Representation $uneRepresentation  : récupération du contenu du formulaire et instanciation d'une représentation */
        $uneRep= new Representation($_REQUEST['id'], $lieu , $groupe , $_REQUEST['laDate'] ,$_REQUEST['hrDb'], $_REQUEST['hrFn']);

        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesRep($uneRep, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour l'établissement
            RepresentationDAO::update($uneRep->getId(), $uneRep);
            // revenir à la liste des établissements
            header("Location: index.php?controleur=representations&action=consulter");
        } else {
            // s'il y a des erreurs,
            // réafficher le formulaire de modification
            $laVue = new VueSaisieRepresentation();
            $this->vue = $laVue;
            $laVue->setUneRepresentation($uneRep);
            $laVue->setLesLieux(LieuDAO::getAll());
            $laVue->setLesGroupes(GroupeDAO::getAll());
            $laVue->setActionRecue("modifier");
            $laVue->setActionAEnvoyer("validerModifier");
            $laVue->setMessage("Modifier la représentation (" . $uneRep->getId() . ")");
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - représentation");
            $this->vue->afficher();
        }
    }

    /** controleur= representations & action=supprimer & id=identifiant_representation
     * Supprimer une representation d'après son identifiant     */
    public function supprimer() {
        $idRep = $_GET["id"];
        $this->vue = new VueSupprimerRepresentation();
        // Lire dans la BDD les données de la représentation à supprimer
        Bdd::connecter();
        $this->vue->setUneRepresentation(RepresentationDAO::getOneById($idRep));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - représentation");
        $this->vue->afficher();
    }

    /** controleur= representation & action= validerSupprimer
     * supprimer une représentation dans la base de données après confirmation   */
    public function validerSupprimer() {
        Bdd::connecter();
        if (!isset($_GET["id"])) {
            // pas d'identifiant fourni
            GestionErreurs::ajouter("Il manque l'identifiant de la représentation à supprimer");
        } else {
            // suppression de la représentation d'après son identifiant
            RepresentationDAO::delete($_GET["id"]);
        }
        // retour à la liste des représentations
        header("Location: index.php?controleur=representations&action=consulter");
    }

    /**
     * Vérification des données du formulaire de saisie
     * @param Representation $uneRep représentation à vérifier
     * @param bool $creation : =true si formulaire de création d'une nouvelle représentation ; =false sinon
     */
    private function verifierDonneesRep(Representation $uneRep, bool $creation) {
        // Vérification des champs obligatoires.
        // Dans le cas d'une création, on vérifie aussi l'id
        if (($creation && $uneRep->getId() == "") || $uneRep->getLieu() == "" || $uneRep->getGroupe() == "" || $uneRep->getHeureDebut() == "" ||
            $uneRep->getHeureFin() == "" ) {
            GestionErreurs::ajouter('Chaque champ suivi du caractère * est obligatoire');
        }

        if($creation){
            if (RepresentationDAO::isAnExistingId($uneRep->getId())) {
                GestionErreurs::ajouter("La représentation " . $uneRep->getId() . " existe déjà");
            }
        }

        // Vérification qu'une représentation ne soit pas sur le même lieu en même temps qu'une autre représentation
        if ($uneRep->getLieu() != "" && $uneRep->getHeureDebut() != "" && $uneRep->getHeureFin() != "" && RepresentationDAO::isAnExistingRep($creation, $uneRep)) {
            GestionErreurs::ajouter("Une représentation ce passe déjà à " . $uneRep->getLieu()->getNom() . " entre " . $uneRep->getHeureDebut() . " et " . $uneRep->getHeureFin() . ".");
        }
        // Vérification que le groupe soit déjà dans une représentation
        if ($uneRep->getGroupe() != "" && RepresentationDAO::isAnExistingGrp($creation, $uneRep->getGroupe())) {
            GestionErreurs::ajouter("Le groupe " . $uneRep->getGroupe()->getNom() . " a déjà une représentation.");
        }

        // Vérification que l'heure de début ne soit pas supérieur à l'heure de fin
        if($uneRep->getHeureFin() != "" && $uneRep->getHeureDebut() != "" && compDate($uneRep->getHeureDebut(), $uneRep->getHeureFin())){
            GestionErreurs::ajouter("L'heure de début ne doit pas être supérieur à l'heure de fin, ou le temps d'une représentation doit être supérieur à 30 minutes.");
        }

    }
}