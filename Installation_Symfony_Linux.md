#  Installation du projet Symfony sous Linux

Ce fichier vous permettra d'installer et de lancer le projet Symfony sous Linux.

## Installer AMPPS

Dans le Bash, tapez la commande suivante :

`sudo apt-get update`

Installez les dépendances d'AMPPS :

`sudo apt-get install libfontconfig1 libxrender1`

Téléchargez AMPPS :

`wget http://s4.softaculous.com/a/ampps/files/Ampps-3.8-x86_64.run`

(Si vous n'avez pas wget :)

`sudo apt-get install wget`

Dans le dossier où se situe votre téléchargement :

`sudo chmod 0755 Ampps-3.8-x86_64.run`

`sudo ./Ampps-3.8-x86_64.run`

## Installer PHP 7.3

Vous pouvez installer une version postérieure de PHP mais la 7.3 est le minimum requis pour lancer le projet symfony.

Commencez par installer PPA :

`sudo apt install software-properties-common`

`sudo add-apt-repository ppa:ondrej/php`

`sudo apt update`

Puis, installez PHP 7.3 FPM :

`sudo apt install php7.3-fpm`

Puis, PHP 7.3 pour Apache :

`sudo apt install php7.3`

Installez toutes les extensions nécessaires :

`sudo apt install php7.3-common php7.3-mysql php7.3-xml php7.3-xmlrpc php7.3-curl php7.3-gd php7.3-imagick php7.3-cli php7.3-dev php7.3-imap php7.3-mbstring php7.3-opcache php7.3-soap php7.3-zip php7.3-intl -y`

## Installer la CLI de Symfony

Tapez la commande :

`wget https://get.symfony.com/cli/installer`

## Déplacer le fichier protech dans AMPPS

Déplacez le dossier du projet Symfony nommé _protech_ dans `/usr/local/ampps/Ampps/www`

## Lancer AMPPS

Utilisez la commande :

`cd /usr/local/ampps`

Ensuite, lancez Ampps avec la commande :

`sudo ./Ampps`

Si vous avez des problèmes d'affichage lancez plutôt :

`sudo QT_X11_NO_MITSHM=1 /usr/local/ampps/Ampps`

Vérifiez bien que AMPPS est configuré sur PHP 7.3, sinon il faudra l'installer sur AMPPS.

## Création de la base de données MySQL

Dans la fenêtre d'AMPPS, cliquez sur le bouton en forme de maison, puis sur _phpMyAdmin_.
Si cela ne fonctionne pas, dans un navigateur web, entrez l'URL `http://localhost/phpmyadmin/`

Dans le menu de gauche, créez une base de données que vous nommerez _db_protech_.

Sélectionnez l'onglet _importer_, puis cliquez sur le bouton _choisir un fichier_.
Déplacez-vous dans le dossier _db_protech.sql_ et choisissez une table à importer. Puis, cliquez sur _Exécuter_ en bas de la page.
Répétez cette opération jusqu'à avoir importé toutes les tables présentes dans le fichier _db_protech.sql_.

Dans les tables _statistics_, _tweets_ et _web_requests_, supprimez la colonne _id_.
Puis, recréez une colone _id_ en début de table en sélectionnant _A_I_ (pour auto increment).

## Lancer le projet Symfony

Dans le Bash, placez vous dans le dossier _protech_ situé au chemin `/usr/local/ampps/Ampps/www`

Tapez la commande :

`php /bin/console server:run`

Ou bien si cela ne fonctionne pas :

`symfony server:start`

Cela lance le projet symfony.

Enfin, dans un navigateur web, recopier l'URL renvoyée en ajoutant à la fin `/home` pour accéder au site web e-usticia.
