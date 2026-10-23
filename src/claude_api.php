<?php

# ----------------------------------------------------------------------------------------
# Fonction pour envoyer des requêtes à l'API Anthropic
# ----------------------------------------------------------------------------------------
# $requestBody = array contenant le corps de l'appel à l'API Anthropic
# $client = instance de la classe GuzzleHttp\Client pour faire appel à l'API
# $endpoint = URL de l'API à appeler
# $key = clé API utilisée pour l'appel
function sendRequest($requestBody, $client, $endpoint, $key) : ?array {
    try {
        $response = $client->post($endpoint, [
            'headers' => [
                'x-api-key' => $key,
                'anthropic-version' => '2023-06-01',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($requestBody),
        ]);

        $result = json_decode($response->getBody(), true);
        return $result;
    } catch (Exception $e) {
        echo "Error : " . $e->getMessage();
        return null;
    }
}

# ----------------------------------------------------------------------------------------
# Fonction pour récupérer le texte de la réponse de l'API
# ----------------------------------------------------------------------------------------
# $response est la réponse renvoyée par l'API, sous forme de dictionnaire (clé=>valeur).
# Le champ texte, qui nous intéresse, se trouve dans le dictionnaire qui a pour clé 'content'
# et qui a pour valeur un tableau d'autres dictionnaires
function getResponseText($response) : ?string {
    foreach ($response['content'] as $dict) {
        if ($dict['type'] === 'text') {
            return $dict['text'];
        }
    }
    return null;
}