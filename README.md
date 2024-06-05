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


Si docker est installé localement: http://localhost:10290/admin devrait lancer l'application

## Accès

http://localhost:10290/admin

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
>

## Approche et Méthodologie

Pour répondre à la demande du client et créer un tableau de bord visuellement attrayant, voici la méthode que j'ai suivie :

### Bibliothèques utilisées :

- **EasyAdmin 4** : Une bibliothèque qui permet de créer des interface d'administration sur Symfony.
- **ChartJs** : Une bibliothèque JavaScript utilisée pour créer des graphiques dynamiques et interactifs.
- **Bootstrap** : Un framework CSS pour garantir que l'application soit responsive.
- **Axios** : Utilisé pour récupérer les données dynamiques et les mettre à jour en temps réel sans recharger la page.

### Étapes suivies :

1. **Création du tableau de bord (Dashboard)** :
   - Implémentation de l'interactivité dans les graphiques pour permettre aux utilisateurs de cliquer sur des segments et d'afficher des informations détaillées.
   - Le premier graphique permet de visualiser tous les groupes d'unités.
   - Le deuxième graphique permet de visualiser le nombre de membres par unité dans un groupe d'unité spécifique.
   - Le troisième graphique permet de visualiser le nombre de membres par section dans une unité spécifique.

2. **Création de l'interface d'administration avec EasyAdmin** :
   - Création de l'outil de recherche, qui permet grâce à une barre de recherche de trouver rapidement un membre
   - Recherche d'un membre en fonction de ses informations personnelles ou de son appartenance au sein des Scouts.

### Résultat :

Le tableau de bord final offre une vue d'ensemble des données de la fédération avec des graphiques interactifs et des informations détaillées. 

- La partie Dashboard permet de visualiser les données chiffrées pour voir rapidement quels sont les différents groupes d'unités, unités, sections et membres qui les composent.
  
- La partie Recherche met l'accent sur l'accès rapide aux informations d'un membre en fonction de son nom, prénom, mail, mais aussi sa section, son unité ou son groupe d'unité.

Durant ce projet, mon objectif a été d'utiliser des bibliothèques pertinentes et modernes pour créer une interface utilisateur intuitive, en appliquant les bonnes pratiques de développement web.



