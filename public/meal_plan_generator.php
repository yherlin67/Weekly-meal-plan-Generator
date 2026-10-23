<?php

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    header("Location: index.php");
    exit;
}
if(empty($_POST['ingredients']) || empty($_POST['nb_pers']) || empty($_POST['mealsSlot']))
{
    header("Location: index.php");
    exit;
}
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/claude_api.php';
require __DIR__ . '/../src/prompt.php';

use GuzzleHttp\Client;

# URL de l'API à appeler
$endpoint = 'https://api.anthropic.com/v1/messages';

# Nombre de personnes pour les recettes à générer
$nbPeople = $_POST['nb_pers'];

# Ingrédients disponibles pour la recette
$ingredients = $_POST['ingredients'];

# Créneaux pour lesquels on va générer des repas (exemple, Mardi soir, Mercredi midi...)
$mealsSlot = $_POST['mealsSlot'];

#Création du prompt pour le rôle system (fonction dans prompt.php)
$systemPrompt = buildSystemPrompt();

#Création du prompt pour le rôle user (fonction dans prompt.php)
$userPrompt = buildUserPrompt($nbPeople,$ingredients,$mealsSlot);

# Instanciation d'un client Guzzle pour faire appel à l'API
# Timeout car le client doit attendre la génération du menu
$client = new Client(['timeout' => 120]);

$requestBody = [
    'model' => $model,
    'max_tokens' => 16000,
    'system' => $systemPrompt,
    'messages' => [
        [
            'role' => 'user',
            'content' => $userPrompt
        ]
    ],
    # Dans 'output_config' = on force la sortie de la requête en format JSON : plus facile à lire pour l'affichage
    # dans templates/meal_plan.php. 
    # Le champ 'required' indique les champs obligatoires parmi 'properties'
    # Le champ 'additionalProperties' indique si l'API peut renvoyer d'autres champs que ceux de 'properties'
    'output_config' => [
        'format' => [
            'type'   => 'json_schema',
            'schema' => [
                'type'       => 'object',
                'properties' => [
                    'meals' => [
                        'type'  => 'array',
                        'items' => [
                            'type'       => 'object',
                            'properties' => [
                                'day'         => ['type' => 'string', 'enum' => $days],
                                'moment'      => ['type' => 'string', 'enum' => $moments],
                                'name'        => ['type' => 'string'],
                                'ingredients' => ['type' => 'array', 'items' => ['type' => 'string']],
                                'steps'       => ['type' => 'array', 'items' => ['type' => 'string']],
                            ],
                            'required'             => ['day', 'moment', 'name', 'ingredients', 'steps'],
                            'additionalProperties' => false,
                        ],
                    ],
                ],
                'required'             => ['meals'],
                'additionalProperties' => false,
            ],
        ],
    ],
];

# TODO : vérifier que les données de $_POST ne contiennent pas d'erreur dans validation.php

$response = sendRequest($requestBody, $client, $endpoint, $apiKey);

if ($response === null) {
    $errorMessage = "Erreur lors de l'appel à l'API.";
} elseif ($response['stop_reason'] === 'max_tokens') {
    $errorMessage = "La réponse a été coupée, elle était trop longue.";
} else {
    $mealPlan = json_decode(getResponseText($response), true);
    $grid = [];
    # $mealPlan['meals'] est un tableau contenant tous nos repas générés. On les stocke ici dans une grille
    # Exemple grid[Lundi][Midi] = meal1
    foreach ($mealPlan['meals'] as $meal) {
        $grid[$meal['day']][$meal['moment']] = $meal;
    }
}

# C'est à partir de ce moment là qu'on a besoin du template meal_plan.php pour afficher notre réponse...
# On exécute le template tout à la fin pour qu'il ait accès à toutes les variables
require __DIR__ . '/../templates/meal_plan.php';