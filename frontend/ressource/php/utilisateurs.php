<?php

/**
 * Vérifie si les données sont valides
 * 
 * @param string $email
 * @param string $motDePasse
 * @return array|bool true si les données sont valides, un tableau d'erreurs sinon
 */
function verifierUtilisateur(string $email, string $motDePasse) : array|bool
{
    $erreurs = [];

    if ($email === null || $email === '') {
        $erreurs['email'] = "L'email est obligatoire";
    }

    if ($motDePasse === null || $motDePasse === '') {
        $erreurs['mot_de_passe'] = "Le mot de passe est obligatoire";
    }

    if (empty($erreurs)) {
        return true;
    }

    return $erreurs;
}

/**
 * Recupère l'utilisateur dont l'id est passé en paramètre
 *
 * @param  int    $id
 * @return mixed Retourne un tableau si l'utilisateur est trouvé, false sinon
 */
function recupererUtilisateur(int $id) : array | false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

/**
 * Recupère l'utilisateur dont l'email est passé en paramètre
 *
 * @param  string    $email
 * @return mixed Retourne un tableau si l'utilisateur est trouvé, false sinon
 */
function recupererUtilisateurParEmail(string $email) : array | false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare('SELECT * FROM utilisateurs WHERE email = :email');

    $stmt->execute([':email' => $email]);

    return $stmt->fetch();
}

/**
 * Vérifie la validité du jeton. Un jeton est valide s'il est lié à un utilisateur
 *
 * @param  string $jeton
 * @return bool true si le jeton est valide, false sinon
 */
function verifierValiditeJeton($jeton) : bool
{
    $utilisateur = recupererUtilisateurParJeton($jeton);

    if (!$utilisateur) {
        return false;
    }

    return true;
}

/**
 * Recupère l'utilisateur dont le jeton est passé en paramètre
 *
 * @param  string $jeton
 * @return mixed Retourne un tableau si l'utilisateur est trouvé, false sinon
 */
function recupererUtilisateurParJeton(string $jeton) : array | false
{
    $bdd = connexionBdd();

    $stmt = $bdd->prepare('SELECT * FROM utilisateurs WHERE jeton=:jeton');
    $stmt->execute([':jeton' => $jeton]);

    return $stmt->fetch();
}
