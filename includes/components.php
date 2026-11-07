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
