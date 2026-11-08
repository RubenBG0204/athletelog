<?php
declare(strict_types=1);

/*
 * Configuración global de AthleteLog.
 * Se devuelve como array para que bootstrap.php la guarde en $config
 * y ningún otro fichero tenga valores "mágicos" repartidos por el código.
 */
return [
    // Datos generales: se muestran en el título, la navbar y el footer.
    'app_name'     => 'AthleteLog',
    'student_name' => 'Rubén Barrutia Grasa',
    'timezone'     => 'Europe/Madrid',
    // Con true se muestran los errores de PHP; ponerlo a false al publicar.
    'debug'        => true,

    // Límites de validación. Viven aquí para usarlos igual en el servidor
    // (validateRegistration) y en los atributos HTML5 del formulario.
    'rules' => [
        'name_min'     => 3,    // nombre completo: longitud mínima y máxima
        'name_max'     => 50,
        'username_min' => 4,    // usuario: longitud mínima y máxima
        'username_max' => 15,
        'password_min' => 8,    // contraseña: longitud mínima
        'age_min'      => 16,   // edad: rango permitido
        'age_max'      => 60,
    ],
];
