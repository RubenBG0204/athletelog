<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Inicio';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <section class="hero">
        <h1>Bienvenido a <?= e($config['app_name']) ?></h1>
        <p class="lead">
            El cuaderno de entrenamiento digital para deportistas de competición:
            anota cada sesión, consulta tu historial y entrena con método.
        </p>
        <a class="button" href="register.php">Crear mi cuenta</a>
        <a class="button button-secondary" href="sports.php">Ver deportes</a>
    </section>

    <section class="feature-grid">
        <article class="card">
            <h3>Regístrate</h3>
            <p>Crea tu perfil con tu deporte principal, tu nivel competitivo y los días en los que entrenas.</p>
        </article>
        <article class="card">
            <h3>Anota tus entrenamientos</h3>
            <p>Registra deporte, duración y sensaciones de cada sesión en unos segundos.</p>
        </article>
        <article class="card">
            <h3>Consulta tu historial</h3>
            <p>Revisa tu evolución y comprueba si entrenas con la constancia que buscas.</p>
        </article>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
