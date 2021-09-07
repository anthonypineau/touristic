<?php

namespace controleur;


use modele\dao\Bdd;
use modele\dao\GroupeDAO;
use modele\metier\Groupe;
use vue\groupes\VueDetailGroupe;
use vue\groupes\VueSaisieGroupe;
use vue\groupes\VueListeGroupes;
use vue\groupes\VueSupprimerGroupe;

class CtrlGroupes extends ControleurGenerique
{
    /** controleur= groupes & action= defaut
     * Afficher la liste des groupes      */
    public function defaut() {
        $this->liste();
    }

    /** controleur= groupes & action= liste
     * Afficher la liste des groupes      */
    public function liste() {
        $laVue = new VueListeGroupes();
        $this->vue = $laVue;
        // On récupère un tableau composé de la liste des groupes avec, pour chacun,
        //  son nombre d'attributions de chambres actuel :

        Bdd::connecter();
        $lesGroupes = GroupeDAO::getAll();
        $laVue->setLesGroupes($lesGroupes);
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");
        $this->vue->afficher();
    }

    /** controleur= groupes & action=detail & id=identifiant_groupe
     * Afficher un groupe d'après son identifiant     */
    public function detail() {
        $idGroup = $_GET["id"];
        $this->vue = new VueDetailGroupe();
        // Lire dans la BDD les données du groupe à afficher
        Bdd::connecter();
        $this->vue->setUnGroupe(GroupeDAO::getOneById($idGroup));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");
        $this->vue->afficher();
    }

    /** controleur= groupes & action=creer
     * Afficher le formulaire d'ajout d'un groupe     */
    public function creer() {
        $laVue = new VueSaisieGroupe();
        $this->vue = $laVue;
        $laVue->setActionRecue("creer");
        $laVue->setActionAEnvoyer("validerCreer");
        $laVue->setMessage("Nouveau groupe ");
        // En création, on affiche un formulaire vide
        /* @var Groupe $unGroup */
        $unGroup = new Groupe("", "", "", "", "", "", "");
        $laVue->setUnGroupe($unGroup);
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");
        $this->vue->afficher();
    }

    /** controleur= groupes & action=validerCreer
     * ajout d'un groupe dans la base de données d'après la saisie    */
    public function validerCreer() {
        Bdd::connecter();
        /* @var Groupe $unGroup  : récupération du contenu du formulaire et instanciation d'un groupe */
        $unGroup = new Groupe($_REQUEST['id'], $_REQUEST['nom'], $_REQUEST['identite'], $_REQUEST['adresse'], $_REQUEST['nbPers'], $_REQUEST['nomPays'], $_REQUEST['hebergement']);
        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de création (paramètre n°1 = true)
        $this->verifierDonneesGroup($unGroup, true);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer le groupe
            GroupeDAO::insert($unGroup);
            // revenir à la liste des groupes
            header("Location: index.php?controleur=groupes&action=liste");
        } else {
            // s'il y a des erreurs,
            // réafficher le formulaire de création
            $laVue = new VueSaisieGroupe();
            $this->vue = $laVue;
            $laVue->setActionRecue("creer");
            $laVue->setActionAEnvoyer("validerCreer");
            $laVue->setMessage("Nouveau groupe");
            $laVue->setUnGroupe($unGroup);
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - groupes");
            $this->vue->afficher();
        }
    }

    /** controleur= groupes & action=modifier $ id=identifiant du groupes à modifier
     * Afficher le formulaire de modification d'un groupes     */
    public function modifier() {
        $idGroup = $_GET["id"];
        $laVue = new VueSaisieGroupe();
        $this->vue = $laVue;
        // Lire dans la BDD les données du groupe à modifier
        Bdd::connecter();
        /* @var Groupe $leGroupe */
        $leGroupe = GroupeDAO::getOneById($idGroup);
        $this->vue->setUnGroupe($leGroupe);
        $laVue->setActionRecue("modifier");
        $laVue->setActionAEnvoyer("validerModifier");
        $laVue->setMessage("Modifier le groupe : " . $leGroupe->getNom() . " (" . $leGroupe->getId() . ")");
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");
        $this->vue->afficher();
    }

    /** controleur= groupes & action=validerModifier
     * modifier un groupes dans la base de données d'après la saisie    */
    public function validerModifier() {
        Bdd::connecter();
        /* @var Groupe $unGroup  : récupération du contenu du formulaire et instanciation d'un groupe */
        $unGroup = new Groupe($_REQUEST['id'], $_REQUEST['nom'], $_REQUEST['identite'], $_REQUEST['adresse'], $_REQUEST['nbPers'], $_REQUEST['nomPays'], $_REQUEST['hebergement']);

        // vérifier la saisie des champs obligatoires et les contraintes d'intégrité du contenu
        // pour un formulaire de modification (paramètre n°1 = false)
        $this->verifierDonneesGroup($unGroup, false);
        if (GestionErreurs::nbErreurs() == 0) {
            // s'il ny a pas d'erreurs,
            // enregistrer les modifications pour le groupe
            GroupeDAO::update($unGroup->getId(), $unGroup);
            // revenir à la liste des groupes
            header("Location: index.php?controleur=groupes&action=liste");
        } else {
            // s'il y a des erreurs,
            // réafficher le formulaire de modification
            $laVue = new VueSaisieGroupe();
            $this->vue = $laVue;
            $laVue->setUnGroupe($unGroup);
            $laVue->setActionRecue("modifier");
            $laVue->setActionAEnvoyer("validerModifier");
            $laVue->setMessage("Modifier le groupe : " . $unGroup->getNom() . " (" . $unGroup->getId() . ")");
            parent::controlerVueAutorisee();
            $laVue->setTitre("Festival - groupes");
            $this->vue->afficher();
        }
    }

    /**
     * Vérification des données du formulaire de saisie
     * @param Groupe $unGroup groupe à vérifier
     * @param bool $creation : =true si formulaire de création d'un nouveau groupe ; =false sinon
     */
    private function verifierDonneesGroup(Groupe $unGroup, bool $creation) {
        // Vérification des champs obligatoires.
        // Dans le cas d'une création, on vérifie aussi l'id
        if (($creation && $unGroup->getId() == "") || $unGroup->getNom() == "" || $unGroup->getNbPers() == "" || $unGroup->getNomPays() == "" ||
            $unGroup->getHebergement() == "") {
            GestionErreurs::ajouter('Chaque champ suivi du caractère * est obligatoire');
        }
        // En cas de création, vérification du format de l'id et de sa non existence
        if ($creation && $unGroup->getId() != "") {
            // Si l'id est constitué d'autres caractères que de lettres non accentuées
            // et de chiffres, une erreur est générée
            if (!estAlphaNumerique($unGroup->getId())) {
                GestionErreurs::ajouter("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
            } else {
                if (GroupeDAO::isAnExistingId($unGroup->getId())) {
                    GestionErreurs::ajouter("Le groupe " . $unGroup->getId() . " existe déjà");
                }
            }
        }

        if($unGroup->getNom() != "" && !estAlphaNumeriqueAccent($unGroup->getNom())){
            GestionErreurs::ajouter('Le nom ne doit pas comporter des caractères spéciaux');
        }

    }

    /** controleur= groupes & action=supprimer & id=identifiant_groupe
     * Supprimer un groupe d'après son identifiant     */
    public function supprimer() {
        $idGroup = $_GET["id"];
        $this->vue = new VueSupprimerGroupe();
        // Lire dans la BDD les données du groupe à supprimer
        Bdd::connecter();

        $this->vue->setUnGroupe(GroupeDAO::getOneById($idGroup));
        parent::controlerVueAutorisee();
        $this->vue->setTitre("Festival - groupes");

        $this->vue->afficher();
    }

    /** controleur= groupes & action= validerSupprimer
     * supprimer un groupe dans la base de données après confirmation   */
    public function validerSupprimer() {
        Bdd::connecter();
        if (!isset($_GET["id"])) {
            // pas d'identifiant fourni
            GestionErreurs::ajouter("Il manque l'identifiant du groupe à supprimer");
        } else {
            // suppression du groupe d'après son identifiant
            GroupeDAO::delete($_GET["id"]);
        }
        // retour à la liste des groupes
        header("Location: index.php?controleur=groupes&action=liste");
    }
}