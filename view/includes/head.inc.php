<?php
/**
 * @author apineau
 * @version 2021
 */
use controller\ParametersHandling;
?>
<!DOCTYPE html">
<html lang="fr">
    <head>
        <title><?= $this->getTitle() ?></title>
        <!-- <base href="<?= ParametersHandling::get('root') ?>" /> -->
        <meta http-equiv="Content-Language" content="fr">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="view/styles/main.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" type="image/png" href="./assets/logo.png"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,700,700i%7CHeebo:300,300i,400,400i,700,700i%7COpen+Sans:300,300i,400,400i,700,700i%7CHeebo:300,300i,400,400i,700,700i" media="all">
    </head>
    <body>
        <div class="header">
            <div class="menu">
                <ul>
                    <li><a href="index.php?controller=home">Accueil</a></li>
                    <li><a href="index.php?controller=paca">Région PACA</a></li>
                    <li><a href="index.php?controller=ra">Région Rhône-Alpes</a></li>
                    <li><a href="index.php?controller=pdl">Région Pays de la Loire</a></li>
                    <li><a href="index.php?controller=references">Références</a></li>
                </ul>
            </div>
        </div>
        <div class="center">