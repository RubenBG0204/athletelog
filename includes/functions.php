<?php
declare(strict_types=1);

/*
 * Funciones de utilidad y de validación.
 * No imprimen nada: reciben datos y devuelven un resultado, así se pueden
 * probar por separado y reutilizar desde cualquier página.
 */

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
    // Se queda con los deportes cuya 'category' coincide con la pedida.
    return array_filter(
        $sports,
        static fn(array $sport): bool => $sport['category'] === $category
    );
}

/**
 * Lee un campo de texto de $_POST sin fiarse de su tipo.
 *
 * Si falta, o llega como array (campo[]=x manipulado a mano), devuelve ''.
 * Las contraseñas se leen con $trim = false: un espacio puede ser intencionado.
 */
function readString(array $input, string $key, bool $trim = true): string
{
    // Si el campo no existe se usa '' como valor por defecto.
    $value = $input[$key] ?? '';

    // Un atacante puede enviar campo[]=x, que llega como array: se descarta.
    if (!is_string($value)) {
        return '';
    }

    return $trim ? trim($value) : $value;
}

/**
 * Convierte lo recibido del formulario de registro en valores con el tipo esperado.
 * Con un array vacío devuelve los valores por defecto (formulario sin enviar).
 */
function readRegistrationInput(array $input): array
{
    $days = $input['days'] ?? [];

    return [
        // Campos de texto: se leen como string y se recortan los espacios de los extremos.
        'fullname'  => readString($input, 'fullname'),
        'username'  => readString($input, 'username'),
        'email'     => readString($input, 'email'),
        // Contraseñas: sin recortar, porque un espacio puede formar parte de la clave.
        'password'  => readString($input, 'password', false),
        'password2' => readString($input, 'password2', false),
        // La edad se guarda como texto; se convierte a entero al validarla.
        'age'       => readString($input, 'age'),
        // Deporte y nivel: llegan como clave de $sports y $levels.
        'sport'     => readString($input, 'sport'),
        'level'     => readString($input, 'level'),
        // Solo se aceptan textos: un array anidado nunca será un día válido.
        'days'      => is_array($days) ? array_values(array_filter($days, 'is_string')) : [],
        // Un checkbox sin marcar no se envía; marcado envía "yes". Se convierte a true/false.
        'privacy'   => readString($input, 'privacy') === 'yes',
    ];
}

/**
 * Valida el formulario de registro en el servidor (el HTML5 se puede saltar).
 *
 * Devuelve un array [campo => mensaje]. Si está vacío, todos los datos son válidos.
 */
function validateRegistration(
    array $values,
    array $sports,
    array $levels,
    array $trainingDays,
    array $rules
): array {
    // Aquí se acumulan los errores, uno por campo.
    $errors = [];

    // Nombre completo: no vacío y entre 3 y 50 caracteres (mb_strlen cuenta bien las tildes).
    $nameLength = mb_strlen($values['fullname']);
    if ($values['fullname'] === '') {
        $errors['fullname'] = 'El nombre completo es obligatorio.';
    } elseif ($nameLength < $rules['name_min'] || $nameLength > $rules['name_max']) {
        $errors['fullname'] = sprintf(
            'El nombre debe tener entre %d y %d caracteres.',
            $rules['name_min'],
            $rules['name_max']
        );
    }

    // Usuario: solo letras, números y _.
    // El modificador D evita que "$" acepte un salto de línea final.
    $usernamePattern = sprintf(
        '/^[A-Za-z0-9_]{%d,%d}$/D',
        $rules['username_min'],
        $rules['username_max']
    );
    if ($values['username'] === '') {
        $errors['username'] = 'El usuario es obligatorio.';
    } elseif (preg_match($usernamePattern, $values['username']) !== 1) {
        $errors['username'] = sprintf(
            'El usuario debe tener entre %d y %d caracteres '
            . 'y solo puede contener letras, números y guion bajo (_).',
            $rules['username_min'],
            $rules['username_max']
        );
    }

    // Email: se comprueba con el validador de formato que trae PHP.
    if ($values['email'] === '') {
        $errors['email'] = 'El email es obligatorio.';
    } elseif (filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'El email no tiene un formato válido.';
    }

    // Contraseña: longitud mínima y repetición idéntica.
    if (mb_strlen($values['password']) < $rules['password_min']) {
        $errors['password'] = sprintf(
            'La contraseña debe tener al menos %d caracteres.',
            $rules['password_min']
        );
    }
    if ($values['password2'] !== $values['password']) {
        $errors['password2'] = 'Las contraseñas no coinciden.';
    }

    // Edad: entero dentro del rango. filter_var devuelve false si no es un entero válido.
    $age = filter_var($values['age'], FILTER_VALIDATE_INT, [
        'options' => ['min_range' => $rules['age_min'], 'max_range' => $rules['age_max']],
    ]);
    if ($age === false) {
        $errors['age'] = sprintf(
            'La edad debe ser un número entero entre %d y %d.',
            $rules['age_min'],
            $rules['age_max']
        );
    }

    // Deporte y nivel: el valor enviado debe ser una clave de los arrays maestros.
    if (!array_key_exists($values['sport'], $sports)) {
        $errors['sport'] = 'Elige un deporte principal de la lista.';
    }
    if (!array_key_exists($values['level'], $levels)) {
        $errors['level'] = 'Elige tu nivel competitivo.';
    }

    // Días de entrenamiento: al menos uno, y todos deben existir en $trainingDays.
    // array_diff() devuelve los días enviados que no están en la lista de días válidos.
    if ($values['days'] === []) {
        $errors['days'] = 'Marca al menos un día de entrenamiento.';
    } elseif (array_diff($values['days'], array_keys($trainingDays)) !== []) {
        $errors['days'] = 'Alguno de los días marcados no es válido.';
    }

    // Consentimiento obligatorio.
    if (!$values['privacy']) {
        $errors['privacy'] = 'Debes aceptar el tratamiento de tus datos para registrarte.';
    }

    // Array vacío = formulario válido.
    return $errors;
}
