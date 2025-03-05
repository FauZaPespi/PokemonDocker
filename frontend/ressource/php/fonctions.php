<?php

require_once 'constantes.php';

/**
 * Retourne une connexion à la base de données
 *
 * @return PDO L'objet
 */
function connexionBdd() : PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=mariadb-container;dbname=' . BDD_NOM . ';charset=' . BDD_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, BDD_UTILISATEUR, BDD_MOT_DE_PASSE, $options);
    }

    return $pdo;
}

/**
 * Récupère les données envoyées au serveur
 * 
 * @return array les données, le tableau est vide si les données n'ont pu être décodées
 */
function recupererDonnees() : array
{
    $contenu = file_get_contents("php://input");


    if ($contenu === false) {
        return [];
    }

    $donnees = json_decode($contenu, true);

    if (!is_array($donnees)) {
        return [];
    }

    return $donnees;
}

/**
 * Retourne le jeton d'authentification Bearer
 *
 * @return string|false Le jeton si trouvé, false sinon
 */
function recupererJeton() : string|false
{
    $entetes = getallheaders();

    if (!array_key_exists('Authorization', $entetes)) {
        return false;
    }

    $bearer = explode(' ', $entetes['Authorization']);

    if ($bearer[0] === 'Bearer') {
        return $bearer[1];
    }

    return false;
}

/**
 * Envoie les données
 * 
 * @array $donnees
 * @int   $statutHttp
 *
 * @return void
 */
function envoyerDonnees(array $donnees, int $statutHttp = STATUT_HTTP_OK) : void
{
    http_response_code($statutHttp);
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($donnees);
    die();
}
