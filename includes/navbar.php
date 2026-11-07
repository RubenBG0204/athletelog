<?php
declare(strict_types=1);

// Fichero => texto del enlace. Añadir una página al menú es añadir una línea.
$navLinks = [
    'index.php'       => 'Inicio',
    'register.php'    => 'Registro',
    'login.php'       => 'Login',
    'training.php'    => 'Nuevo entrenamiento',
    'history.php'     => 'Historial',
    'preferences.php' => 'Preferencias',
];

// basename() deja solo el nombre del fichero ("/athletelog/index.php" => "index.php").
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
    <nav class="navbar" aria-label="Navegación principal">
        <a class="brand" href="index.php"><?= e($config['app_name']) ?></a>
        <ul class="nav-links">
            <?php foreach ($navLinks as $file => $label): ?>
                <li>
                    <a href="<?= e($file) ?>"<?= $file === $currentPage ? ' class="active" aria-current="page"' : '' ?>><?= e($label) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
