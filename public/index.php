<?php

// Twig
require_once '../lib/vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader("../src/vue");
$twig = $twig = new \Twig\Environment($loader, []);

require_once '../src/controleur/_controleurs.php';
require_once '../config/route.php';

$contenu = getPage();
$contenu($twig);

?>