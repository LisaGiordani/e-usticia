#  Installation du projet Symfony sous Windows

Ce fichier vous permettra d'installer et de lancer le projet Symfony sous Windows.

## Installer AMPPS

Installez AMPPS sur le site : [lien vers le site](https://ampps.com/download?fbclid=IwAR3H88HVl31ts34Be1_lfocdPMpo8XKWMLMvmRd6hlYdAyKT-iOebnjjnmc)

## Vérifier la version de php

Dans la console Windows, tapez cette commande pour vérifier la version de php installée :

`php --version`

Ou bien, si cela ne fonctionne pas, ouvrez AMPPS et regardez sur la fenêtre qui s'ouvre quelle est la version de php utilisée.

Il faut que la version de php soit la 7.3, sinon la télécharger.

## Installer la CLI de Symfony

Installez la CLI de Symfony sur le site : [lien vers le site](https://sourceforge.net/projects/wampserver/)https://symfony.com/download)

## Déplacer le fichier protech dans AMPPS

Ouvrez AMPPS, cliquez sur le bouton en forme de dossier.
Déplacer le fichier _protech_ à cet endroit.

## Création de la base de données MySQL

Dans la fenêtre d'AMPPS, cliquez sur le bouton en forme de maison, puis sur _phpMyAdmin_.

Dans le menu de gauche, créez une base de données que vous nommerez _db_protech_.

Sélectionnez l'onglet _importer_, puis cliquez sur le bouton _choisir un fichier_.
Déplacez-vous dans le dossier _db_protech.sql_ et choisissez une table à importer. Puis, cliquez sur _Exécuter_ en bas de la page.
Répétez cette opération jusqu'à avoir importé toutes les tables présentes dans le fichier _db_protech.sql_.

Dans les tables _statistics_, _tweets_ et _web_requests_, supprimez la colonne _id_.
Puis, recréez une colone _id_ en début de table en sélectionnant _A_I_ (pour auto increment).

## Lancer le projet Symfony

Dans la console Windows, déplacez vous dans le fichier du projet Symfony nommé _protech_ avec la commande :

`cd C:\Program Files\Ampps\www\protech`

Puis, lancer le serveur :

`symfony server:start`

Ou bien, si cela ne fonctionne pas, avec la commande suivante :

`php bin\console server:run`

Enfin, dans un navigateur web, recopier l'URL renvoyée en ajoutant à la fin `/home` pour accéder au site web e-usticia.
