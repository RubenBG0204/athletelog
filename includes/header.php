<?php
declare(strict_types=1);

// Cada página define $pageTitle antes de incluir este fichero.
// El valor por defecto evita un aviso si alguna página se olvida de hacerlo.
$pageTitle = $pageTitle ?? 'Inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> · <?= e($config['app_name']) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
