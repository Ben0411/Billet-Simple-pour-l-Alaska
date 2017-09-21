# Oc : Projet 3 => Créez un blog pour un écrivain

## Installation

La première chose à faire est de créer son vhosts sous Apache.
Pour cela, ouvrez votre fichier `httpd-vhosts.conf` qui se trouve dans votre dossier apache `C:/wamp/bin/apache/apacheX.X.X/conf/extra`.
Puis ajouter les lignes suivantes à la fin du fichier
```
<VirtualHost *:80>
    ServerName ton-host

    DocumentRoot /dossier-racine-du-site/web
    <Directory /dossier-racine-du-site/web >
	Require all granted
        AllowOverride All
        Order Allow,Deny
        Allow from All
        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>
```
Il ne faut pas oublier de modifier ce vhosts pour qu'il corresponde à votre configuration. Je fais référence aux 3 instructions suivantes :
* `ServerName` : Il faut y insérer votre host, en gros le nom de domaine (en local) pour aller sur votre site en local.
* `DocumentRoot` : C'est le chemin du dossier web de votre site
* `Directory` : C'est le chemin du dossier web de votre site

Assurez vous de bien avoir activer le module mod_rewrite dans apache.
Je vous conseille de vous renseigner sur la méthode de réécriture d'URL pour comprendre les quelques lignes de votre vhosts.

C'est le fichier `web/index.php` qui fera office d'amorceur.

N'oubliez pas de vous assurer que la ligne `#Include conf/extra/httpd-vhosts.conf` est bien décompentée dans le fichier `C:/wamp/bin/apache/apacheX.X.X/conf/httpd.conf`.
