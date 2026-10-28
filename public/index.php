<?php
    session_start();
    # Je charge la liste d'ingrédients que je vais proposer à l'utilisateur
    # json_decode() transforme un texte JSON en tableau PHP
    $ingredients = json_decode(file_get_contents(__DIR__ . '/../data/ingredients.json'), true);
    require __DIR__ . '/../src/config.php';

    $pageTitle = 'Weekly meal plan Generator';
    # Utilisation du style css Bootstrap5 pour la bibliothèque Tom Select
    $pageStyles = ['https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css'];
    require __DIR__ . '/../templates/header.php';
?>
<body class="text-center">
<h1>Weekly meal plan generator</h1>
<br>
<form method='post' action='meal_plan_generator.php'>
    <p>Nombres de personnes :</p><input type="number" name="nb_pers" min="1" max="10" step="1" value="2">
    </br>
    </br>
    <div class="container zone-ingredients">
        <p>Ingrédients disponibles :
            <span data-bs-toggle="tooltip" title="Les ingrédients que vous possédez déjà chez vous"><i class="bi bi-info-circle"></i></span>
        </p>
        <!-- Tom Select masque ce select et affiche son propre champ à la place, les choix sont ensuite reportés dans le select original -->
        <!-- multiple = plusieurs choix, Tom Select passe en mode étiquettes / name="ingredients[]" = stocke un tableau dans la variable $_POST['ingredients'] -->
        <select id="ingredients" name="ingredients[]" multiple>
        <?php foreach ($ingredients as $category => $ingredientList): ?>
            <optgroup label="<?= htmlspecialchars($category) ?>">
                <?php foreach ($ingredientList as $ingredient): ?>
                    <option value="<?= htmlspecialchars($ingredient) ?>"><?= htmlspecialchars($ingredient) ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
        </select>
    </div>
    <br>
    <p>Fréquence de repas :</p>
    <table class="table zone-repas">
        <thead>
            <tr>
                <th></th>
                <?php foreach ($moments as $moment): ?>
                    <th><?= $moment ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($days as $day): ?>
                <tr>
                    <th><?= $day ?></th>
                    <?php foreach ($moments as $moment): ?>
                        <td>
                            <!-- exemple : $_POST['mealsSlot'] = ['Lundi' => ['Midi','Soir']] -->
                            <input type="checkbox" class="form-check-input"
                                name="mealsSlot[<?= $day ?>][]" value="<?= $moment ?>">
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <p>Budget course de la semaine :
        <span data-bs-toggle="tooltip" title="Montant maximum pour acheter les ingrédients que l'IA ajoutera elle-même aux recettes"><i class="bi bi-info-circle"></i></span>
    </p><input type="number" name="weekBudget" min="50" max="10000" step="1" value="50"><span> €</span>
    <br>
    <br>
    <button type="submit" class="btn btn-primary">Générer mes repas</button>
</form>
<!-- Script qui contient la bibliothèque TomSelect complète, avec ses plugins -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<?php
    require __DIR__ . '/../templates/footer.php';
?>