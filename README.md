# README - Mon Projet Symfony

Bienvenue dans le projet Symfony "canaljob" ! Ce fichier README vous guidera à travers les étapes nécessaires pour lancer l'application après l'avoir récupérée depuis GitHub.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre système :

- [PHP](https://www.php.net/) (version 8 ou supérieure obligatoire)
- [Composer](https://getcomposer.org/) (gestionnaire de dépendances PHP)
- [Symfony CLI](https://symfony.com/download) (pour les commandes Symfony)

## Installation

1. Clonez le projet depuis GitHub :

   ```bash
   git clone https://github.com/BenoitGueheneux/canaljob.git
   ```

2. Accédez au répertoire du projet :

   ```bash
   cd canaljob
   ```

3. Installez les dépendances PHP en utilisant Composer :

   ```bash
   composer install
   ```

## Configuration

1. Configurez votre base de données dans le fichier `.env` en modifiant la variable `DATABASE_URL` avec vos informations de connexion.

## Création de la base de données

1. Créez la base de données en utilisant la commande Symfony :

   ```bash
   bin/console doctrine:database:create
   ```

2. Mettez à jour le schéma de la base de données :

   ```bash
   bin/console doctrine:migrations:migrate
   ```

## Lancement du serveur de développement

Pour lancer le serveur de développement Symfony, exécutez la commande suivante :

```bash
symfony serve
```

L'application sera accessible à l'adresse [http://127.0.0.1:8000](http://127.0.0.1:8000).
