<?php

# Charge automatiquement toutes les bibliothèques installées par Composer (Guzzle et phpdotenv pour mon projet)
# __DIR__ vaut src/ et /.. remonte à la racine du projet, là où se trouve le dossier vendor
require __DIR__ .'/../vendor/autoload.php';

use Dotenv\Dotenv;

# Indique à phpdotenv le dossier où chercher le .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

# Maintenant que la variable $_ENV a été chargée, on récupère les infos du .env
$apiKey = $_ENV['ANTHROPIC_API_KEY'];
$model  = $_ENV['ANTHROPIC_MODEL'];





