<?php
declare(strict_types=1);

/*
 * CAPA 3 DEL LAYOUT: pie de página.
 * Muestra el copyright y cierra el <body> y el <html> que abrió header.php.
 */
?>
<footer class="site-footer">
    <?php /* date('Y') da el año actual, así el pie no hay que actualizarlo cada enero. */ ?>
    <p>&copy; <?= date('Y') ?> <?= e($config['app_name']) ?> · <?= e($config['student_name']) ?></p>
</footer>
</body>
</html>
