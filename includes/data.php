<?php
declare(strict_types=1);

/*
 * Datos maestros de la aplicación.
 *
 * Son arrays asociativos: la clave es un identificador estable ('running')
 * y el valor es lo que se muestra al usuario. Los formularios envían la clave,
 * así que validar un campo consiste en comprobar que esa clave existe aquí.
 */

// Deportes disponibles. category: 'individual' | 'equipo'. unit: unidad en que se mide el entrenamiento.
$sports = [
    'running'       => ['name' => 'Running',      'category' => 'individual', 'unit' => 'km'],
    'swimming'      => ['name' => 'Natación',     'category' => 'individual', 'unit' => 'metros'],
    'cycling'       => ['name' => 'Ciclismo',     'category' => 'individual', 'unit' => 'km'],
    'weightlifting' => ['name' => 'Halterofilia', 'category' => 'individual', 'unit' => 'kg'],
    'football'      => ['name' => 'Fútbol',       'category' => 'equipo',     'unit' => 'minutos'],
    'basketball'    => ['name' => 'Baloncesto',   'category' => 'equipo',     'unit' => 'minutos'],
    'volleyball'    => ['name' => 'Voleibol',     'category' => 'equipo',     'unit' => 'minutos'],
    'handball'      => ['name' => 'Balonmano',    'category' => 'equipo',     'unit' => 'minutos'],
];

// Niveles competitivos.
$levels = [
    'beginner'      => 'Iniciación',
    'regional'      => 'Regional',
    'national'      => 'Nacional',
    'international' => 'Internacional',
];

// Días de la semana para el formulario de registro (el orden es el de la semana).
$trainingDays = [
    'mon' => 'Lunes',
    'tue' => 'Martes',
    'wed' => 'Miércoles',
    'thu' => 'Jueves',
    'fri' => 'Viernes',
    'sat' => 'Sábado',
    'sun' => 'Domingo',
];

// Usuarios de prueba. Solo se guarda el hash generado con password_hash(),
// nunca la contraseña en texto plano.
$users = [
    'ana_runner'  => [
        'name'          => 'Ana Puig',
        'password_hash' => '$2y$10$6Rb8Co1qePVd564E8DGE2Onrw86FxdONf4doSHthJ3UeFPn1eS7uy',
        'sport'         => 'running',
    ],
    'marc_swim'   => [
        'name'          => 'Marc Ferrer',
        'password_hash' => '$2y$10$ol9AQVG.IMLQWyzn.St.kurE7kd3NpqvFC9IrGjb44uGzQ8PWSwsG',
        'sport'         => 'swimming',
    ],
    'laia_volley' => [
        'name'          => 'Laia Costa',
        'password_hash' => '$2y$10$sPrXoCVzdMrBO/Kt1Hjune6/LF9foJxbUF1qNIoufVpsUCnUgMnvC',
        'sport'         => 'volleyball',
    ],
];
