<?php

require_once 'fonctions.php';

/**
 * Recupère le pokémon dont l'id est passé en paramètre
 *
 * @param  int    $id
 * @return mixed Retourne un tableau si l'équipe est trouvée, false sinon
 */
function recupererPokemon(int $id) : array | false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare('SELECT * FROM pokemons WHERE id=:id');
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

/**
 * Recupère la liste des pokémons
 *
 * @return array Retourne un tableau contenant les pokémons
 */
function recupererPokemons() : array
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare('SELECT * FROM pokemons');
    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * Insère un pokémon
 * 
 * @param string $nom
 * @param string $type
 * @return int|false l'identifiant du pokemon inséré ou false si une erreur survient
 */
function insererPokemon(string $nom, string $type) : int|false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare("INSERT INTO pokemons (`nom`, `type`) VALUES (:nom, :type)");

    $params = [
        ':nom' => $nom,
        ':type' => $type,
    ];

    $succes = $stmt->execute($params);

    if ($succes) {
        return $bdd->lastInsertId();
    }

    return false;
}

/**
 * Modifie une équipe
 * 
 * @param string $id
 * @param string $nom
 * @param string $type
 * @return int|false l'identifiant du pokemon modifié ou false si une erreur survient
 */
function modifierPokemon(int $id, string $nom, string $type) : int|false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare("UPDATE pokemons SET `nom` = :nom, `type` = :type WHERE `id` = :id");

    $params = [
        ':id' => $id,
        ':nom' => $nom,
        ':type' => $type,
    ];

    $succes = $stmt->execute($params);

    if ($succes) {
        return $id;
    }

    return false;
}

/**
 * Efface le pokémon dont l'id est passé en paramètre
 * 
 * @param int $id
 * @return bool true si l'effacement s'est bien déroulé, false sinon
 */
function effacerPokemon(int $id) : bool
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare("DELETE FROM pokemons WHERE id = :id");

    $params = [
        ':id' => $id
    ];

    $succes = $stmt->execute($params);

    return $succes;
}

/**
 * Vérifie si les données sont valides
 * 
 * @param string $nom
 * @param string $type
 * @return array|bool true si les données sont valides, un tableau d'erreurs sinon
 */
function verifierPokemon(string $nom, string $type) : array|bool
{
    $erreurs = [];

    if ($nom === null || $nom === '') {
        $erreurs['nom'] = "Le nom du pokémon est obligatoire";
    }

    if ($type === null || $type === '') {
        $erreurs['type'] = "Le type du pokémon est obligatoire";
    }

    if (empty($erreurs)) {
        return true;
    }

    return $erreurs;
}

function ajouterImageAuPokemon(array $pokemon) : array
{
    try {
	$image = strtolower($pokemon['nom']) . '.png';

	if (file_exists('images/' . $image)) {
		$pokemon['image'] = '/images/' . $image;
	} else {
		$pokemon['image'] = null;
	}
    }
    catch (Exception $ex) {
        echo "erreur $ex";
    }
	return $pokemon;
}