<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Historial';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <?= renderComingSoon('Historial de entrenamientos') ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
