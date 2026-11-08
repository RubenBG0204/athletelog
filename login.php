<?php
declare(strict_types=1);

// Arranque común: configuración, funciones y datos.
require_once __DIR__ . '/includes/bootstrap.php';

// Título que usará header.php en la pestaña del navegador.
$pageTitle = 'Login';

// Capas superiores del layout: cabecera del documento y menú.
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <?php /* Sección aún sin implementar: renderComingSoon() pinta un aviso reutilizable. */ ?>
    <?= renderComingSoon('Inicio de sesión') ?>
</main>
<?php /* Capa inferior del layout: pie de página y cierre del documento. */ ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
