## Installer l'application Symfony

Pour démarrer docker tu peux utiliser 
 ```
sudo make start
 ```
modifie éventuellement les ports utilisés par les containers docker dans le fichier .env
 ```
DOCKER_MYSQL_PORT_3306=10308
DOCKER_APACHE_PORT_80=10290
 ```
Puis utilise les commandes suivantes pour installer le dépendances et mettre en place la base de données.

 ```bash
composer install
php bin/console d:m:m
php bin/console d:f:l
```


Si docker est installé localement: http://localhost:10290 devrait lancer l'application

## Consignes de l'exercice:

Voici une application qui présente la liste des membres de la fédération.

Le staff fédéral, client de cette application, ne trouve pas ça très pratique et formule la demande suivante:

> Cette liste n'est pas très utile, que pouvez-vous nous proposer de plus intéressant visuellement qu'un tableau? Nous voudrions un dashboard de la fédération pour visualiser l'ensemble des données. 


Libre à toi d'installer les librairies que tu souhaites et de modifier le code existant pour répondre à cette demande.

Laisse parler ta créativité et montre nous ce que tu sais faire ;)

**Ce qui nous intéresse est la méthode utilisée, pas le résultat final ! Nous discuterons de l'exercice lors de l'entretien.**

> **_PRECISIONS_**
> 
> Les membres (WsMembre) sont regroupés en sections (WsSection), chaque section appartient à une unité (WsUnite), chaque unité appartient à un groupe d'unité (WsGroupeUnite), et chaque groupe d'unité appartient à une Fédération (WsFederation).
> 
> Ce qui intéresse le client c'est d'avoir une vue sur ces différents éléments (tableaux, graphiques, ...)



