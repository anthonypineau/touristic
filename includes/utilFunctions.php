<?php

/**
 * Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
 * la fonction retourne vrai
 * @param string $valeur
 * @return bool
 */
function estEntier(string $valeur) : bool {
    return preg_match('/[^0-9]/', $valeur) != 1;
}

/**
 * Vérification du contenu alphanumérique d'une chaîne
 * la chaîne ne doit contenir que des caractères ou des chiffres
 * @param string $chaine à tester
 * @return bool =true si la chaîne est alphanumérique
 */
function estAlphaNumerique(string $chaine): bool {
//    $pattern = '/[^a-zA-Z0-9]/'; // Au moins un caractère n'est pas alphanumérique
    $pattern = '/^[a-zA-Z0-9]*$/'; // Tous les caractères sont alphanumériques, s'il y en a
    return preg_match($pattern, $chaine);
}

/**
 * Vérification de la vraisemblance d'une chaîne en tant que code postal
 * @param string $codePostal
 * @return type
 */
function estUnCp(string $codePostal) {
// Le code postal doit comporter 5 chiffres
    return strlen($codePostal) == 5 && estEntier($codePostal);
}


function estAlphaNumeriqueAccent(string $chaine):bool{
    $pattern = '/^[a-zA-Z0-9ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ]*$/'; 
// Tous les caractères sont alphanumériques, s'il y en a
    return preg_match($pattern, $chaine);
}

function compDate(string $hrDbt, string $hrFn):bool{

    $heureDebut = date('H:i',strtotime($hrDbt));
    $heureFin = date('H:i',strtotime($hrFn));
    $heureRep = date('H:i',strtotime('00:30'));
    $heureDif = date('H:i',strtotime($hrFn) - strtotime($hrDbt));

    return $heureDebut >= $heureFin || $heureDif <= $heureRep;
}

function verifRole($role):bool{
    return $_SESSION[role]=!$role;
}
