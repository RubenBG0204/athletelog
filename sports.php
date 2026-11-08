<?php
declare(strict_types=1);

// Arranque común: configuración, funciones y datos ($sports viene de data.php).
require_once __DIR__ . '/includes/bootstrap.php';

// La lógica va arriba: se separan los deportes y luego el HTML solo los pinta.
$individualSports = getSportsByCategory($sports, 'individual');
$teamSports       = getSportsByCategory($sports, 'equipo');

// Título que usará header.php en la pestaña del navegador.
$pageTitle = 'Deportes';

// Capas superiores del layout: cabecera del documento y menú.
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <h1>Deportes disponibles</h1>
    <p class="lead">Estos son los deportes que puedes elegir como principal al registrarte.</p>

    <?php /* renderSportsTable() recorre el array con foreach y devuelve la tabla HTML. */ ?>
    <h2>Deportes individuales</h2>
    <?= renderSportsTable($individualSports) ?>

    <h2>Deportes de equipo</h2>
    <?= renderSportsTable($teamSports) ?>
</main>
<?php /* Capa inferior del layout: pie de página y cierre del documento. */ ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
