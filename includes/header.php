<?php
declare(strict_types=1);

/*
 * CAPA 1 DEL LAYOUT: cabecera del documento.
 * Abre <html>, <head> y <body>. El <body> y el <html> se cierran en footer.php,
 * por eso este fichero y el footer se incluyen siempre en pareja.
 */

// Cada página define $pageTitle antes de incluir este fichero.
// El valor por defecto evita un aviso si alguna página se olvida de hacerlo.
$pageTitle = $pageTitle ?? 'Inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php /* Codificación de caracteres: necesaria para que se vean bien las tildes y la ñ. */ ?>
    <meta charset="UTF-8">
    <?php /* Hace que la página se adapte al ancho de la pantalla en móviles. */ ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php /* Título de la pestaña: "Página · AthleteLog". e() lo escapa por seguridad. */ ?>
    <title><?= e($pageTitle) ?> · <?= e($config['app_name']) ?></title>
    <?php /* Hoja de estilos única. La ruta es relativa porque todas las páginas están en la raíz. */ ?>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
