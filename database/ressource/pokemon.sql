--
-- Initialisation de la base de données
--
DROP DATABASE IF EXISTS pokemon;
CREATE DATABASE pokemon DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP USER IF EXISTS utilisateur_pokemon@localhost;
CREATE USER utilisateur_pokemon@localhost IDENTIFIED BY 'motdepasse_pokemon';

GRANT INSERT ON pokemon.* TO utilisateur_pokemon@localhost;
GRANT SELECT ON pokemon.* TO utilisateur_pokemon@localhost;
GRANT UPDATE ON pokemon.* TO utilisateur_pokemon@localhost;
GRANT DELETE ON pokemon.* TO utilisateur_pokemon@localhost;

DROP USER IF EXISTS utilisateur_pokemon@'%';
CREATE USER utilisateur_pokemon@'%' IDENTIFIED BY 'motdepasse_pokemon';

GRANT INSERT ON pokemon.* TO utilisateur_pokemon@'%';
GRANT SELECT ON pokemon.* TO utilisateur_pokemon@'%';
GRANT UPDATE ON pokemon.* TO utilisateur_pokemon@'%';
GRANT DELETE ON pokemon.* TO utilisateur_pokemon@'%';

USE pokemon;

--
-- Structure de la table `pokemons`
--

DROP TABLE IF EXISTS `pokemons`;
CREATE TABLE `pokemons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(100) NOT NULL,
  `jeton` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Insertion des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` VALUES (1,'sacha@pokemon.ch','$2y$10$NSQEQPlkvnNfJ8DQHpsYVOLe/8R94xORIf9L58caLYS3UXVnwZ.GG','63a01a25ee5371.95385483');
