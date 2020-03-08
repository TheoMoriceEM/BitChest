# BitChest
Projet final de développement web pour L'École Multimédia

Adresse du projet GitHub : https://github.com/TheoMoriceEM/BitChest

Le MCD est situé à la racine du projet sous format mwb (MySQL WorkBench). Pour pouvoir le consulter, téléchargez le logiciel ici : https://dev.mysql.com/downloads/workbench/


**Procédure à suivre pour installer le projet en local :**
1. Créez une base de données sur votre serveur.
2. Copiez le fichier .env.example et renommez-le en .env.
3. Remplissez-le comme suit :
..* APP_NAME=BitChest
..* APP_URL='votre chemin vers le dossier public'
..* Dans la partie DB, saisissez les informations de connexion à votre base de données.
4. Saisissez la commande "composer install" pour installer les dépendances de Composer.
5. Saisissez la commande "php artisan key:generate" pour générer une clé d'application.
6. Saisissez la commande "php artisan migrate --seed" pour lancer les migrations et seeders pour peupler votre base de données.
7. Rendez-vous à l'adresse du site en local. Dans l'interface d'authentification, cliquez sur Inscription pour vous créer un compte ou connectez-vous à l'aide du compte d'un utilisateur existant (généré par les seeders) : pour cela, allez chercher l'adresse email d'un utilisateur dans la base de données et tapez "password" comme mot de passe.

Vous pouvez désormais explorer l'application comme bon vous semble !
