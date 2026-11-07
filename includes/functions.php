<?php
declare(strict_types=1);

/**
 * Escapa un texto para imprimirlo de forma segura en HTML.
 *
 * Es un atajo de htmlspecialchars(): así no repetimos los flags ni el
 * charset en cada vista y es más difícil olvidarse de escapar.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Devuelve solo los deportes de una categoría ('individual' o 'equipo').
 *
 * array_filter() conserva las claves ('running', 'football'...), que
 * necesitamos más adelante para los formularios y la validación.
 */
function getSportsByCategory(array $sports, string $category): array
{
    return array_filter(
        $sports,
        static fn(array $sport): bool => $sport['category'] === $category
    );
}
