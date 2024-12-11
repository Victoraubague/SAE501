#!/bin/bash

# Exécuter PHPUnit dans le conteneur Symfony
docker exec symfony_c_sae501 vendor/bin/phpunit --coverage-html ./html