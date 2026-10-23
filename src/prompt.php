<?php

# ----------------------------------------------------------------------------------------
# Fonction pour construire le prompt du rôle system = permet de donner
# du contexte à l'agent avant de lui poser une question
# ----------------------------------------------------------------------------------------
function buildSystemPrompt() : string {

    $prompt = 'Tu es un cuisinier. Ton objectif est de créer une liste de repas 
    pour certains jours de la semaine, à partir de certains ingrédients, et pour un certain
    nombre de personnes. Propose des repas variés. Tu peux te permettre de rajouter des ingrédients
    qui n\'ont pas été renseignés par l\'utilisateur, dans la limite du raisonnable. Pars du principe
    que le sel et le poivre sont des ingrédients inclus de base';

    return $prompt;
}

# ----------------------------------------------------------------------------------------
# Fonction pour construire le prompt du rôle user = permet de construire
# une demande adaptée aux choix qu'a fait l'utilisateur dans le formulaire d'index.php
# ----------------------------------------------------------------------------------------
function buildUserPrompt($nbPeople, $ingredients, $mealsSlot) : string {
    $prompt = "Nombre de personnes : " . $nbPeople . "\n";
    # Fonction PHP implode : assemble les éléments d'un tableau en une seule chaîne, avec le séparateur choisi
    $prompt .= "Ingrédients disponibles : " . implode(', ', $ingredients) . "\n";
    $prompt .= "Repas à prévoir :\n";

    foreach ($mealsSlot as $day => $chosenMoments) {
        $prompt .= "- " . $day . " : " . implode(', ', $chosenMoments) . "\n";
    }

    return $prompt;
}