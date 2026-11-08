<?php
declare(strict_types=1);

/*
 * Punto de arranque común: cada página lo incluye con require_once.
 * Centralizar aquí las dependencias evita que cada página tenga que
 * acordarse de cargarlas (y de hacerlo en el orden correcto).
 */

// 1. Configuración: config.php devuelve un array, que se guarda en $config.
$config = require __DIR__ . '/../config/config.php';

// 2. Ajustes de PHP: errores visibles solo si 'debug' está activado, y hora de España.
error_reporting(E_ALL);
ini_set('display_errors', $config['debug'] ? '1' : '0');
date_default_timezone_set($config['timezone']);

// 3. Código compartido. El orden importa: components.php usa e() de functions.php.
require_once __DIR__ . '/functions.php';   // funciones de utilidad y validación
require_once __DIR__ . '/data.php';        // datos maestros: $sports, $levels, $trainingDays, $users
require_once __DIR__ . '/components.php';  // funciones que devuelven trozos de HTML
