<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

// La lógica va arriba: se separan los deportes y luego el HTML solo los pinta.
$individualSports = getSportsByCategory($sports, 'individual');
$teamSports       = getSportsByCategory($sports, 'equipo');

$pageTitle = 'Deportes';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <h1>Deportes disponibles</h1>
    <p class="lead">Estos son los deportes que puedes elegir como principal al registrarte.</p>

    <h2>Deportes individuales</h2>
    <?= renderSportsTable($individualSports) ?>

    <h2>Deportes de equipo</h2>
    <?= renderSportsTable($teamSports) ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
