# SAE501
SAE 501 avec l'IA. - Par *Victor AUBAGUE* et *Hélie DESCHAMPS*
Adresse GitHub du projet : https://github.com/Victoraubague/SAE501

## 0/ Prérequis
- Docker & Docker-compose

## 1/ Installation et lancement du container
Dans ce projet, vous trouverez un fichier ``docker-compose.yml``.
Ce fichier contient un container **symfony**, contenant une image PHP avec RubixML et Symfony et un container **nginx**, contenant une image d'un serveur Nginx connécté au container symfony.
Ces deux containers sont mappé pour utiliser les ports hôte suivants :
- *9003*, utilisé par xdebug pour le container **symfony**
- *8000*, utilisé par le serveur **nginx**, c'est le port d'accès à l'application web

Pour lancer le container, il suffit de se placer dans le dossier racine du projet et de lancer la commande suivante :
```bash
docker-compose up -d
```
Cette commande va lancer les deux containers en arrière-plan.
Si les ports *9003* et *8000* sont disponibles, vous pouvez accéder à l'application web à l'adresse suivante : [http://localhost:8000](http://localhost:8000).
Notez que le premier lancement peut prendre un peu de temps, **symfony** doit télécharger les dépendances composer dont il a besoin.

## 2/ Récupération des images
Avant d'utiliser l'application, il vous faudra télécharger les images nécessaires à l'entraînement et au test du modèle.
Pour cela, téléchargez le fichier ``images.zip`` à l'adresse suivante : https://drive.google.com/file/d/1qWv_9GOh3QVMRctZw6XLGt_UMxY1ykux/view?usp=sharing et décompressez-le dans le dossier ``symfony/resources/images``.

## 3/ Entraînement du modèle
**Un modèle est déjà entraîné et disponible dans le dossier ``symfony/resources/models``. Il n'est donc pas nécessaire de l'entraîner à nouveau.**

Le prosessus d'entraînement du modèle est automatisé. Pour lancer l'entraînement, il vous faudra vous connecter au container **symfony**. Depuis lequel vous pourrez lancer la commande suivante :
```bash
php scripts/make_models.php
```
Pour lancer cette commande dans un terminal hors du container, utilisez plutôt la commande suivante :
```bash
docker exec symfony_c_sae501 php scripts/make_models.php
```
Cette commande va entraîner le modèle et le sauvegarder dans le dossier ``symfony/resources/models``.

## 4/ Lancez les tests unitaires
Pour lancer les tests unitaires, il vous faudra vous connecter au container **symfony**. Depuis lequel vous pourrez lancer la commande suivante :
```bash
vendor/bin/phpunit
```
Pour lancer cette commande dans un terminal hors du container, utilisez plutôt la commande suivante :
```bash
docker exec symfony_c_sae501 vendor/bin/phpunit
```
Cette commande peut être completé en fin par `` --coverage-html ./var`` pour générer un rapport de couverture dans le fichier ``symfony/var/index.html``.
Un rapport de couverture est par ailleurs déjà généré.

## 5/ Utilisation de l'application
L'application est accessible à l'adresse suivante : [http://localhost:8000](http://localhost:8000).
Vous pouvez y tester le modèle en lui soumettant une image de chiffre manuscrit depuis l'un des fichier testing obtenus depuis le ``.zip`` obtenu dans la partie Récupération des images.