<?php
session_start();

// Twig
require_once '../lib/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader("../src/vue");
$twig = $twig = new \Twig\Environment($loader, []);
$twig->addGlobal('session', $_SESSION);

// Controleur et route
require_once '../src/controleur/_controleurs.php';
require_once '../config/route.php';

// Base de donnée
require_once '../../parametres.php';
require_once '../config/connexion.php';
require_once '../src/modele/_classe.php';

$db = connect($config);
$contenu = getPage($db);
$contenu($twig, $db);

?>