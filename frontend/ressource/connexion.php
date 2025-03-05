<?php

require_once 'php/constantes.php';
require_once 'php/fonctions.php';
require_once 'php/utilisateurs.php';

$typeRequete = $_SERVER['REQUEST_METHOD'];

if ($typeRequete === 'POST') {
    $donnees = recupererDonnees();

    $email = array_key_exists('email', $donnees) ? filter_var($donnees['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    $motDePasse = array_key_exists('mot_de_passe', $donnees) ? filter_var($donnees['mot_de_passe'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

    $valide = verifierUtilisateur($email, $motDePasse);

    if (is_array($valide)) {
        envoyerDonnees(['erreurs' => $valide], STATUT_HTTP_MAUVAISE_REQUETE);
    }

    $utilisateur = recupererUtilisateurParEmail($email);

    if ($utilisateur === false) {
        envoyerDonnees(['erreurs' => "L'utilisateur est introuvable"], STATUT_HTTP_MAUVAISE_REQUETE);
    }

    $succes = password_verify($motDePasse, $utilisateur['mot_de_passe']);

    if ($succes) {
        unset($utilisateur['mot_de_passe']);
        envoyerDonnees(['donnees' => $utilisateur], STATUT_HTTP_OK);
    }

    envoyerDonnees(['erreurs' => "Le mot de passe est incorrect"], STATUT_HTTP_MAUVAISE_REQUETE);
}

http_response_code(STATUT_HTTP_METHODE_NON_AUTORISEE);