###################
Mise en place de l'environnement
###################

-  `docker compose up build -d`_
-  `composer install`_
-  `symfony server:start`_

Page d'acceuil (Liste des articles) : http://127.0.0.1:8000/


*******************
Aggregation des données
*******************

Ouvrir ces liens afin de déclencher l'import des articles dans la base de données :

-  `http://127.0.0.1:8000/data/aggregator/source1`_
-  `http://127.0.0.1:8000/data/aggregator/source2`_
-  `http://127.0.0.1:8000/data/aggregator/source4`_


*******************
API
*******************

Lien de la documentation API afin d'effectuer les manipulations des données : 
-  `http://127.0.0.1:8000/api`_ 



*******************
Détails
*******************
Durée estimée de travail: 2h30

Tâches : 
    - Création de l'entité Article
    - Création des parsers (json - xml - csv)
    - DataAggregator le service qui gère les imports.
    - Utilisation de API platform pour exposer les articles, et la documentation



