<?php

function accueilControleur($twig){
    echo $twig->render("accueil.html.twig", array());
}

function contactControleur($twig){
    echo $twig->render("contact.html.twig", array());
}

function maintenanceControleur($twig){
    echo $twig->render("maintenance.html.twig", array());
}

?>