<?php

require_once 'php/constantes.php';
require_once 'php/fonctions.php';
require_once 'php/pokemons.php';
require_once 'php/utilisateurs.php';

$typeRequete = $_SERVER['REQUEST_METHOD'];

switch ($typeRequete) {
	case 'GET' :
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        // Aucun paramètre n'a été envoyé
        if ($id === null) {
            $pokemons = recupererPokemons();

            // Ajouter l'image
            foreach ($pokemons as $cle => $pokemon) {
            	$pokemons[$cle] = ajouterImageAuPokemon($pokemon);
            }

            envoyerDonnees(['donnees' => $pokemons], STATUT_HTTP_OK);
        }
        // On renvoie le pokémon correspondant à l'id demandé
        $pokemon = recupererPokemon($id);
        if ($pokemon != null) {
            $pokemon = ajouterImageAuPokemon($pokemon);
            
            // Le pokémon n'a pas été trouvée dans la base
            if ($pokemon === false) {
                envoyerDonnees(['erreur' => "Pokémon non trouvé."], STATUT_HTTP_NON_TROUVE);
            }
        
            envoyerDonnees(['donnees' => $pokemon], STATUT_HTTP_OK);
        }
		break;
    case 'POST':
    	$jeton = recupererJeton();

        if (!$jeton) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        if (!verifierValiditeJeton($jeton)) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        $donnees = recupererDonnees();

        $nom = array_key_exists('nom', $donnees) ? filter_var($donnees['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
        $type = array_key_exists('type', $donnees) ? filter_var($donnees['type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

        $valide = verifierPokemon($nom, $type);

        if (is_array($valide)) {
            envoyerDonnees(['erreurs' => $valide], STATUT_HTTP_MAUVAISE_REQUETE);
        }

        $insertion = insererPokemon($nom, $type);

        if ($insertion !== false) {
            $pokemon = recupererPokemon($insertion);
        	$pokemon = ajouterImageAuPokemon($pokemon);
            envoyerDonnees(['donnees' => $pokemon], STATUT_HTTP_OK);
        }

        envoyerDonnees(['erreurs' => 'Erreur du serveur'], STATUT_HTTP_ERREUR_DU_SERVEUR);

        break;
    case 'PUT':
        $jeton = recupererJeton();

        if (!$jeton) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        if (!verifierValiditeJeton($jeton)) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            envoyerDonnees(['erreurs' => "L'identifiant n'est pas un identifiant valide"], STATUT_HTTP_MAUVAISE_REQUETE);
        }

        $pokemon = recupererPokemon($id);

        if ($pokemon === false) {
            envoyerDonnees(['erreurs' => "Le pokémon demandé n'existe pas"], STATUT_HTTP_NON_TROUVE);
        }

        $donnees = recupererDonnees();

        $nom = array_key_exists('nom', $donnees) ? filter_var($donnees['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
        $type = array_key_exists('type', $donnees) ? filter_var($donnees['type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;

        $valide = verifierPokemon($nom, $type);

        if (is_array($valide)) {
            envoyerDonnees(['erreurs' => $valide], STATUT_HTTP_MAUVAISE_REQUETE);
        }

        $modification = modifierPokemon($id, $nom, $type);

        if ($modification !== false) {
            $pokemon = recupererPokemon($id);
        	$pokemon = ajouterImageAuPokemon($pokemon);
            envoyerDonnees(['donnees' => $pokemon], STATUT_HTTP_OK);
        }

        envoyerDonnees(['erreurs' => 'Erreur du serveur'], STATUT_HTTP_ERREUR_DU_SERVEUR);

        break;
    case 'DELETE' :
        $jeton = recupererJeton();

        if (!$jeton) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        if (!verifierValiditeJeton($jeton)) {
            envoyerDonnees(['message' => 'Accès interdit'], STATUT_HTTP_NON_AUTORISE);
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            envoyerDonnees(['erreurs' => "L'identifiant n'est pas un identifiant valide"], STATUT_HTTP_MAUVAISE_REQUETE);
        }

        $pokemon = recupererPokemon($id);

        if ($pokemon === false) {
            envoyerDonnees(['erreurs' => "Le pokémon demandé n'existe pas"], STATUT_HTTP_NON_TROUVE);
        }

        $effacement = effacerPokemon($id);

        if ($effacement !== false) {
            envoyerDonnees(['message' => "La suppression s'est bien déroulée"], STATUT_HTTP_OK);
        }

        envoyerDonnees(['erreurs' => 'Erreur du serveur'], STATUT_HTTP_ERREUR_DU_SERVEUR);

        break;
	default :
        http_response_code(STATUT_HTTP_METHODE_NON_AUTORISEE);
		break;
}
