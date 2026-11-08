<?php
declare(strict_types=1);

/*
 * Componentes de interfaz: funciones que devuelven un trozo de HTML.
 * Se usan desde varias páginas para no repetir el mismo código (DRY).
 * Todo texto que se imprime pasa por e() para escaparlo.
 */

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
    // Sin deportes no tiene sentido pintar una tabla vacía.
    if ($sports === []) {
        return '<p>No hay deportes en esta categoría.</p>';
    }

    // Una fila <tr> por deporte: clave, nombre y unidad.
    $rows = '';
    foreach ($sports as $key => $sport) {
        $rows .= sprintf(
            '<tr><td><code>%s</code></td><td>%s</td><td>%s</td></tr>',
            e((string) $key),
            e($sport['name']),
            e($sport['unit'])
        );
    }

    // Se une la cabecera con las filas generadas.
    return '<table class="data-table">'
        . '<thead><tr><th>Clave</th><th>Deporte</th><th>Unidad</th></tr></thead>'
        . '<tbody>' . $rows . '</tbody>'
        . '</table>';
}

/** Clase CSS del contenedor de un campo: añade "has-error" si ese campo falló. */
function fieldClass(array $errors, string $field, string $extra = ''): string
{
    $classes = trim('field ' . $extra . (isset($errors[$field]) ? ' has-error' : ''));

    return e($classes);
}

/** Mensaje de error junto a su campo (cadena vacía si no hay error). */
function renderFieldError(array $errors, string $field): string
{
    // Si ese campo no tiene error, no se pinta nada.
    if (!isset($errors[$field])) {
        return '';
    }

    return sprintf('<p class="field-error">%s</p>', e($errors[$field]));
}

/**
 * Opciones de un <select> a partir de un array "clave => texto".
 * La opción cuya clave coincide con $selected sale marcada (formulario sticky).
 */
function renderOptions(array $options, string $selected): string
{
    // Primera opción vacía: obliga a elegir una de verdad (su valor '' no existe en $sports).
    $html = '<option value="">— Elige una opción —</option>';

    // Una <option> por elemento; la que coincide con $selected lleva el atributo "selected".
    foreach ($options as $value => $label) {
        $html .= sprintf(
            '<option value="%s"%s>%s</option>',
            e((string) $value),
            (string) $value === $selected ? ' selected' : '',
            e($label)
        );
    }

    return $html;
}

/** Grupo de radio buttons a partir de "clave => texto". */
function renderRadioGroup(string $name, array $options, string $selected): string
{
    // Un radio por elemento; el que coincide con $selected sale marcado (sticky).
    $html = '';
    foreach ($options as $value => $label) {
        $html .= sprintf(
            '<label class="choice"><input type="radio" name="%s" value="%s"%s> %s</label>',
            e($name),
            e((string) $value),
            (string) $value === $selected ? ' checked' : '',
            e($label)
        );
    }

    return $html;
}

/** Grupo de checkboxes a partir de "clave => texto". El name lleva [] para que PHP reciba un array. */
function renderCheckboxGroup(string $name, array $options, array $checked): string
{
    // Un checkbox por elemento; los que están en $checked salen marcados (sticky).
    // in_array() con true compara también el tipo, para no confundir "1" con 1.
    $html = '';
    foreach ($options as $value => $label) {
        $html .= sprintf(
            '<label class="choice"><input type="checkbox" name="%s[]" value="%s"%s> %s</label>',
            e($name),
            e((string) $value),
            in_array((string) $value, $checked, true) ? ' checked' : '',
            e($label)
        );
    }

    return $html;
}
