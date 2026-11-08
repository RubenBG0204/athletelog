<?php
declare(strict_types=1);

/*
 * Datos maestros de la aplicación.
 *
 * Son arrays asociativos: la clave es un identificador estable ('running')
 * y el valor es lo que se muestra al usuario. Los formularios envían la clave,
 * así que validar un campo consiste en comprobar que esa clave existe aquí.
 */

// DEPORTES. Clave => ['name' => texto visible, 'category' => 'individual' | 'equipo',
// 'unit' => unidad en que se mide el entrenamiento]. Los usan sports.php y el registro.
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

// NIVELES COMPETITIVOS. Clave => texto visible. Generan los radio buttons del registro.
$levels = [
    'beginner'      => 'Iniciación',
    'regional'      => 'Regional',
    'national'      => 'Nacional',
    'international' => 'Internacional',
];

// DÍAS DE LA SEMANA. Clave => texto visible. Generan los checkboxes del registro
// (el orden del array es el orden en que se muestran).
$trainingDays = [
    'mon' => 'Lunes',
    'tue' => 'Martes',
    'wed' => 'Miércoles',
    'thu' => 'Jueves',
    'fri' => 'Viernes',
    'sat' => 'Sábado',
    'sun' => 'Domingo',
];

// USUARIOS DE PRUEBA. 'nombre_de_usuario' => ['name', 'password_hash', 'sport'].
// Solo se guarda el hash generado con password_hash(), nunca la contraseña en texto plano.
// 'sport' es una clave de $sports.
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
