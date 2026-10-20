<?php

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    header("Location: index.php");
    exit;
}
if(empty($_POST['ingredients']) || empty($_POST['nb_pers']))
{
    header("Location: index.php");
    exit;
}
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/claude_api.php';

use GuzzleHttp\Client;

# URL de l'API à appeler
$endpoint = 'https://api.anthropic.com/v1/messages';

# Nombre de personne pour la recette à générer
$nb_pers = $_POST['nb_pers'];

# Ingrédients disponibles pour la recette
$ingredients = $_POST['ingredients'];
# Fonction PHP implode : assemble les éléments d'un tableau en une seule chaîne, avec le séparateur choisi
$ingredients_list = implode(', ',$ingredients);

# Instanciation d'un client Guzzle pour faire appel à l'API
# Timeout car le client doit attendre la génération du menu
$client = new Client(['timeout' => 60]);

$requestBodyWithoutContext = [
    'model' => $model,
    'max_tokens' => 16000,
    'messages' => [
        [
            'role' => 'user',
            'content' => 'Salut, génère moi une recette pour '.$nb_pers.
            ' personnes avec les ingrédients suivants : '.$ingredients_list
        ]
    ]
];
# TODO : essayer d'ajouter du context, j'essaye sans pour le moment
# TODO : construire le prompt dans prompt.php et vérifier qu'il ne contient pas d'erreur dans validation.php

sendRequest($requestBodyWithoutContext, $client, $endpoint, $apiKey);