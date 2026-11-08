<?php
declare(strict_types=1);

/*
 * CAPA 2 DEL LAYOUT: barra de navegación.
 */

// Fichero => texto del enlace. Añadir una página al menú es añadir una línea.
$navLinks = [
    'index.php'       => 'Inicio',
    'register.php'    => 'Registro',
    'login.php'       => 'Login',
    'training.php'    => 'Nuevo entrenamiento',
    'history.php'     => 'Historial',
    'preferences.php' => 'Preferencias',
];

// Nombre del fichero que se está visitando, para saber qué enlace resaltar.
// basename() deja solo el nombre ("/athletelog/index.php" => "index.php").
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <nav class="navbar" aria-label="Navegación principal">
        <?php /* Nombre de la app: sirve también de enlace a la portada. */ ?>
        <a class="brand" href="index.php"><?= e($config['app_name']) ?></a>
        <ul class="nav-links">
            <?php /* Un <li> por cada elemento de $navLinks. */ ?>
            <?php foreach ($navLinks as $file => $label): ?>
                <?php $activeAttrs = $file === $currentPage ? ' class="active" aria-current="page"' : ''; ?>
                <li>
                    <a href="<?= e($file) ?>"<?= $activeAttrs ?>><?= e($label) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
