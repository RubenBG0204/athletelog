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
