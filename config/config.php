<?php
declare(strict_types=1);

/*
 * Configuración global de AthleteLog.
 * Se devuelve como array para que bootstrap.php la guarde en $config
 * y ningún otro fichero tenga valores "mágicos" repartidos por el código.
 */
return [
    'app_name'     => 'AthleteLog',
    'student_name' => 'Rubén Barrutia Grasa',
    'timezone'     => 'Europe/Madrid',
    // Con true se muestran los errores de PHP; ponerlo a false al publicar.
    'debug'        => true,
];
