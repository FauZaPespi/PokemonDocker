# Docker MariaDB + Application Frontend PHP

Ce projet montre comment configurer un environnement Dockerisé avec deux services :
- **MariaDB** comme serveur de base de données.
- **Frontend** exécutant un serveur PHP Apache pour servir des fichiers PHP qui interagissent avec la base de données MariaDB.

## Prérequis
- Docker
- Docker Compose

## Structure du projet

- /projet :
   - /database:
      - /ressource: 
         - pokemon.sql
      - Dockerfile
   - /frontend:
      - /ressource: 
         - le ressources du sites
      - Dockerfile
   - README.md
   - setup.sh

      

### Comment ça fonctionne

1. **Conteneur MariaDB** :
   - Le conteneur MariaDB est initialisé avec un script SQL (`pokemon.sql`).
   - Ce conteneur est exposé sur le port `3306`.

2. **Conteneur Frontend** :
   - Le conteneur frontend utilise l'image `php:apache` pour servir les fichiers PHP.
   - Il se connecte au conteneur MariaDB en utilisant des variables d'environnement et affiche les données Pokémon de la base de données.

3. **Communication réseau** :
   - Les deux conteneurs sont connectés via un réseau Docker personnalisé (`app-network`), permettant au conteneur frontend d'accéder au conteneur MariaDB en utilisant le nom du conteneur (`mariadb`).

### Étapes d'utilisation

1. **Construire et démarrer les conteneurs** :
   - Depuis la racine du projet, exécutez la commande suivante pour construire et démarrer les conteneurs :

     ```bash
     docker-compose up --build
     ```

     ou simplement utilisé le setup.sh pour l'installation:

     ```bash
        chmod +x setup.sh
        ./setup.sh 
     ```

2. **Accéder à l'application** :
   - Ouvrez votre navigateur et visitez [http://localhost/pokemon](http://localhost/pokemon/). Cela affichera la liste des Pokémon récupérée depuis la base de données.

3. **Arrêter et supprimer les conteneurs** :
   - Pour arrêter les conteneurs, exécutez :

     ```bash
     docker-compose down
     ```

### Notes
- Vous pouvez modifier le fichier `pokemon.sql` pour ajouter plus de données ou modifier le schéma si nécessaire.
- Vous pouvez également mettre à jour le code PHP dans le dossier `frontend/ressource` pour ajouter des fonctionnalités supplémentaires.
