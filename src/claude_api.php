<?php

# ----------------------------------------------------------------------------------------
# Fonction pour envoyer des requêtes à ma clé API Anthropic
# ----------------------------------------------------------------------------------------
# requestBody = arary contenant le corps de l'appel à l'API Anthropic
# $client = instance de la classe GuzzleHttp\Client pour faire appel à l'API
# $endpoint = URL de l'API à appeler
# $key = clé API utilisée pour l'appel
function sendRequest($requestBody, $client, $endpoint, $key) {
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
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    } catch (Exception $e) {
        echo "Error : " . $e->getMessage();
    }
}
#TODO : remplacer print_r par return après les tests