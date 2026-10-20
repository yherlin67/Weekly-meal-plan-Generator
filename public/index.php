<?php
    session_start();
    # Je charge la liste d'ingrédients que je vais proposer à l'utilisateur
    # json_decode() transforme un texte JSON en tableau PHP
    $ingredients = json_decode(file_get_contents(__DIR__ . '/../data/ingredients.json'), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly meal plan generator</title>
    <!-- Utilisation du framework bootstrap5 pour le style de ma page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Utilisation du style css bootstrap5 pour la bibliothèque Tom Select-->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="text-center">
    <h1>Weekly meal plan generator</h1>
    <form method='post' action='meal_plan_generator.php'>
        <p>Nombres de personnes :</p><input type="number" name="nb_pers" min="1" max="10" step="1" value="2">
        </br>
        </br>
        <div class="container">
            <p>Ingrédients disponibles :</p>
            <!-- Tom Select masque ce select et affiche son propre champ à la place, les choix sont ensuite reportés dans le select original -->
            <!-- multiple = plusieurs choix, Tom Select passe en mode étiquettes / name="ingredients[]" = stocke un tableau dans la variable $_POST['ingredients'] -->
            <select id="ingredients" name="ingredients[]" multiple>
            <?php foreach ($ingredients as $categorie => $liste): ?>
                <optgroup label="<?= htmlspecialchars($categorie) ?>">
                    <?php foreach ($liste as $ingredient): ?>
                        <option value="<?= htmlspecialchars($ingredient) ?>"><?= htmlspecialchars($ingredient) ?></option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
            </select>
        </div>

        </br>
        </br>
        <input type="submit">
    </form>
    <!-- Script qui contient la bibliothèque TomSelect complète, avec ses plugins -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <!-- Lien vers mon script JS qui active et configure Tom Select sur le select des ingrédients -->
    <script src="assets/js/script.js"></script>
</body>
</html>