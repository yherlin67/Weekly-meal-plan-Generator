<?php
    $pageTitle = 'Result';
    require __DIR__ . '/header.php';
?>
<body>
<?php if (isset($errorMessage)): ?>
    <p><?= htmlspecialchars($errorMessage) ?></p>
<?php else: ?>
    <div class="container my-4">
        <h1 class="text-center mb-4">Résultat</h1>

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
        <br>
        <p>Liste des ingrédients à acheter :</p>
        <ul>
        <?php foreach ($mealPlan['purchases'] as $purchase): ?>
            <li><?= htmlspecialchars($purchase) ?></li>
        <?php endforeach; ?>
        </ul>
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">Nouvelle génération</a>
        </div>
    </div>
<?php endif;
require __DIR__ . '/footer.php';
?>