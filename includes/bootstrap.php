<?php
declare(strict_types=1);

/*
 * Punto de arranque común: cada página lo incluye con require_once.
 * Centralizar aquí las dependencias evita que cada página tenga que
 * acordarse de cargarlas (y de hacerlo en el orden correcto).
 */

$config = require __DIR__ . '/../config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', $config['debug'] ? '1' : '0');
date_default_timezone_set($config['timezone']);

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/components.php';
