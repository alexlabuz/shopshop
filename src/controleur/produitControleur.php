<?php

function listeControleur($twig){
    echo $twig->render("liste_article.html.twig", array());
}

function produitControleur($twig){
    echo $twig->render("produit.html.twig", array());
}

?>