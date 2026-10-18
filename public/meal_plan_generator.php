<?php

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    header("Location: index.php");
    exit;
}

require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/claude_api.php';

use GuzzleHttp\Client;

# URL de l'API à appeler
$endpoint = 'https://api.anthropic.com/v1/messages';

# Instanciation d'un client Guzzle pour faire appel à l'API
# Timeout car le client doit attendre la génération du menu
$client = new Client(['timeout' => 60]);

$requestBodyWithoutContext = [
    'model' => $model,
    'max_tokens' => 16000,
    'messages' => [
        [
            'role' => 'user',
            'content' => 'Salut, ca va bien ?'
        ]
    ]
];
# TODO : essayer d'ajouter du context, j'essaye sans pour le moment

sendRequest($requestBodyWithoutContext, $client, $endpoint, $apiKey);