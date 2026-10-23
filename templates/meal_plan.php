<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <!-- Utilisation du framework bootstrap5 pour le style de base de ma page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Utilisation du style css bootstrap5 pour la bibliothèque Tom Select-->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <!-- Utilisation de mon propre fichier css pour des ajustements -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
     <?php if (isset($errorMessage)): ?>
        <p><?= htmlspecialchars($errorMessage) ?></p>
    <?php else: ?>
        <div class="container my-4">
            <h1 class="text-center mb-4">Mes repas de la semaine</h1>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th></th>
                        <?php foreach ($moments as $moment): ?>
                            <th class="text-center"><?= htmlspecialchars($moment) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($days as $day): ?>
                        <!-- S'il n'y a aucune recette pour ce jour là on n'affiche rien -->
                        <?php if (!isset($grid[$day])) continue; ?>
                        <tr>
                            <th><?= htmlspecialchars($day) ?></th>
                            <?php foreach ($moments as $moment): ?>
                                <td>
                                    <?php if (isset($grid[$day][$moment])): ?>
                                        <?php $meal = $grid[$day][$moment]; ?>
                                        <strong><?= htmlspecialchars($meal['name']) ?></strong>
                                            <p class="mb-1 mt-2"><em>Ingrédients :</em></p>
                                            <ul>
                                                <?php foreach ($meal['ingredients'] as $ingredient): ?>
                                                    <li><?= htmlspecialchars($ingredient) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <p class="mb-1"><em>Étapes :</em></p>
                                            <ol>
                                                <?php foreach ($meal['steps'] as $step): ?>
                                                    <li><?= htmlspecialchars($step) ?></li>
                                                <?php endforeach; ?>
                                            </ol>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">Nouvelle génération</a>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>