<?php

function inscrireControleur($twig){
    echo $twig->render("inscrire.html.twig", array());
}

function connectionControleur($twig){
    echo $twig->render("connection.html.twig", array());
}

?>