<?php
declare(strict_types=1);

/**
 * Bloque para las secciones que todavía no están construidas.
 * Se reutiliza en varias páginas en lugar de copiar el mismo HTML.
 */
function renderComingSoon(string $section): string
{
    return sprintf(
        '<section class="card"><h1>%s</h1><p>Esta sección todavía está en construcción.</p></section>',
        e($section)
    );
}

/**
 * Tabla de deportes. Se usa dos veces (individuales y de equipo),
 * por eso vive aquí y no copiada en sports.php.
 */
function renderSportsTable(array $sports): string
{
    if ($sports === []) {
        return '<p>No hay deportes en esta categoría.</p>';
    }

    $rows = '';
    foreach ($sports as $key => $sport) {
        $rows .= sprintf(
            '<tr><td><code>%s</code></td><td>%s</td><td>%s</td></tr>',
            e((string) $key),
            e($sport['name']),
            e($sport['unit'])
        );
    }

    return '<table class="data-table">'
        . '<thead><tr><th>Clave</th><th>Deporte</th><th>Unidad</th></tr></thead>'
        . '<tbody>' . $rows . '</tbody>'
        . '</table>';
}
