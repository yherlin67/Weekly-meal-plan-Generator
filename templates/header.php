<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Utilisation du framework Bootstrap5 pour le style de base de ma page -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Utilisation de Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <?php 
    //Si la page n'a pas défini $pageStyles, on parcourt un tableau vide
    foreach ($pageStyles ?? [] as $style): ?>
        <link href="<?= htmlspecialchars($style) ?>" rel="stylesheet">
    <?php endforeach; ?>
    <!-- Utilisation de mon propre fichier css pour des ajustements -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
