<?php
declare(strict_types=1);

// Arranque común: configuración, funciones y datos.
require_once __DIR__ . '/includes/bootstrap.php';

// Título que usará header.php en la pestaña del navegador.
$pageTitle = 'Inicio';

// Capas superiores del layout: cabecera del documento y menú.
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <?php /* Bloque de bienvenida con la descripción de la app y los botones principales. */ ?>
    <section class="hero">
        <h1>Bienvenido a <?= e($config['app_name']) ?></h1>
        <p class="lead">
            El cuaderno de entrenamiento digital para deportistas de competición:
            anota cada sesión, consulta tu historial y entrena con método.
        </p>
        <a class="button" href="register.php">Crear mi cuenta</a>
        <a class="button button-secondary" href="sports.php">Ver deportes</a>
    </section>

    <?php /* Tres tarjetas que resumen qué se puede hacer con la app. */ ?>
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
<?php /* Capa inferior del layout: pie de página y cierre del documento. */ ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
