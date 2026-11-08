<?php
declare(strict_types=1);

// ===== PARTE 1: LÓGICA (procesa el formulario antes de pintar nada) =====

// Arranque común: configuración, funciones y datos.
require_once __DIR__ . '/includes/bootstrap.php';

// Límites de validación (longitudes, rango de edad...) definidos en config.php.
$rules = $config['rules'];

// Un único fichero: con GET se pinta el formulario vacío; con POST se valida y se vuelve a pintar.
// $isPost:     ¿se ha enviado el formulario?
// $values:     datos recibidos (o valores vacíos si es la primera visita)
// $errors:     [campo => mensaje]; vacío si todo es válido o si aún no se ha enviado
// $registered: true solo si se ha enviado y no hay ningún error
$isPost     = $_SERVER['REQUEST_METHOD'] === 'POST';
$values     = readRegistrationInput($isPost ? $_POST : []);
$errors     = $isPost ? validateRegistration($values, $sports, $levels, $trainingDays, $rules) : [];
$registered = $isPost && $errors === [];

// Las contraseñas ya se han comprobado: se descartan para que nunca lleguen al HTML.
unset($values['password'], $values['password2']);

// Los controles del formulario siempre reciben arrays "clave => texto".
// Aquí se saca de $sports solo el nombre de cada deporte para el <select>.
$sportNames = array_map(static fn(array $sport): string => $sport['name'], $sports);

// Resumen del alta correcta (sin contraseña): etiqueta => valor ya listo para mostrar.
// Se usan los nombres legibles (no las claves) de deporte, nivel y días.
$summary = [];
if ($registered) {
    $summary = [
        'Nombre completo'       => $values['fullname'],
        'Usuario'               => $values['username'],
        'Email'                 => $values['email'],
        'Edad'                  => $values['age'] . ' años',
        'Deporte principal'     => $sports[$values['sport']]['name'],
        'Nivel competitivo'     => $levels[$values['level']],
        'Días de entrenamiento' => implode(', ', array_map(
            static fn(string $day): string => $trainingDays[$day],
            $values['days']
        )),
    ];
}

// ===== PARTE 2: HTML (solo pinta lo que la lógica ya ha preparado) =====

// Título que usará header.php en la pestaña del navegador.
$pageTitle = 'Registro';

// Capas superiores del layout: cabecera del documento y menú.
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <h1>Registro de deportista</h1>

    <?php /* CASO 1: registro correcto. Mensaje de éxito y resumen de los datos (sin contraseña). */ ?>
    <?php if ($registered): ?>
        <div class="alert alert-success" role="status">
            <strong>¡Registro correcto, <?= e($values['fullname']) ?>!</strong>
            Tus datos son válidos. De momento no se almacenan: el alta definitiva llegará en un paso posterior.
        </div>

        <section class="card">
            <h2>Resumen de tus datos</h2>
            <dl class="summary">
                <?php /* Una pareja etiqueta/valor por cada dato del resumen. */ ?>
                <?php foreach ($summary as $label => $value): ?>
                    <dt><?= e($label) ?></dt>
                    <dd><?= e($value) ?></dd>
                <?php endforeach; ?>
            </dl>
            <p><a class="button" href="register.php">Volver al formulario</a></p>
        </section>
    <?php /* CASO 2: primera visita o formulario con errores. Se pinta el formulario. */ ?>
    <?php else: ?>
        <p class="lead">Crea tu perfil de deportista. Todos los campos son obligatorios.</p>

        <?php /* novalidate: desactiva los avisos del navegador para que la validación que cuenta, la del servidor, se vea siempre. */ ?>
        <?php /* action="register.php": el formulario se envía a este mismo fichero. */ ?>
        <form class="form" method="post" action="register.php" novalidate>
            <div class="form-grid">
                <?php /* Nombre completo (text). value="..." conserva lo escrito (sticky). */ ?>
                <div class="<?= fieldClass($errors, 'fullname') ?>">
                    <label for="fullname">Nombre completo</label>
                    <input type="text" id="fullname" name="fullname" value="<?= e($values['fullname']) ?>"
                           minlength="<?= $rules['name_min'] ?>" maxlength="<?= $rules['name_max'] ?>" required>
                    <?= renderFieldError($errors, 'fullname') ?>
                </div>

                <?php /* Usuario (text). pattern: el navegador solo avisa; la validación real es la del servidor. */ ?>
                <div class="<?= fieldClass($errors, 'username') ?>">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" value="<?= e($values['username']) ?>"
                           pattern="[A-Za-z0-9_]{<?= $rules['username_min'] ?>,<?= $rules['username_max'] ?>}"
                           autocomplete="username" required>
                    <p class="field-hint">Letras, números y guion bajo (_). Entre <?= $rules['username_min'] ?> y <?= $rules['username_max'] ?> caracteres.</p>
                    <?= renderFieldError($errors, 'username') ?>
                </div>

                <?php /* Email (email): el tipo "email" ayuda al navegador, pero el servidor vuelve a validarlo. */ ?>
                <div class="<?= fieldClass($errors, 'email') ?>">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= e($values['email']) ?>"
                           autocomplete="email" required>
                    <?= renderFieldError($errors, 'email') ?>
                </div>

                <?php /* Edad (number), con rango mínimo y máximo. */ ?>
                <div class="<?= fieldClass($errors, 'age') ?>">
                    <label for="age">Edad</label>
                    <input type="number" id="age" name="age" value="<?= e($values['age']) ?>"
                           min="<?= $rules['age_min'] ?>" max="<?= $rules['age_max'] ?>" required>
                    <?= renderFieldError($errors, 'age') ?>
                </div>

                <?php /* Contraseña y repetición (password). */ ?>
                <?php /* Por seguridad las contraseñas nunca llevan atributo value: no se rellenan tras un error. */ ?>
                <div class="<?= fieldClass($errors, 'password') ?>">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password"
                           minlength="<?= $rules['password_min'] ?>" autocomplete="new-password" required>
                    <p class="field-hint">Mínimo <?= $rules['password_min'] ?> caracteres.</p>
                    <?= renderFieldError($errors, 'password') ?>
                </div>

                <div class="<?= fieldClass($errors, 'password2') ?>">
                    <label for="password2">Repite la contraseña</label>
                    <input type="password" id="password2" name="password2" autocomplete="new-password" required>
                    <?= renderFieldError($errors, 'password2') ?>
                </div>

                <?php /* Deporte principal (select). Las <option> se generan recorriendo $sports. */ ?>
                <div class="<?= fieldClass($errors, 'sport', 'field-wide') ?>">
                    <label for="sport">Deporte principal</label>
                    <select id="sport" name="sport" required>
                        <?= renderOptions($sportNames, $values['sport']) ?>
                    </select>
                    <?= renderFieldError($errors, 'sport') ?>
                </div>

                <?php /* Nivel competitivo (radio). Los botones se generan recorriendo $levels. */ ?>
                <fieldset class="<?= fieldClass($errors, 'level', 'field-wide') ?>">
                    <legend>Nivel competitivo</legend>
                    <div class="choices">
                        <?= renderRadioGroup('level', $levels, $values['level']) ?>
                    </div>
                    <?= renderFieldError($errors, 'level') ?>
                </fieldset>

                <?php /* Días de entrenamiento (checkbox múltiple). Se generan recorriendo $trainingDays. */ ?>
                <fieldset class="<?= fieldClass($errors, 'days', 'field-wide') ?>">
                    <legend>Días de entrenamiento</legend>
                    <div class="choices">
                        <?= renderCheckboxGroup('days', $trainingDays, $values['days']) ?>
                    </div>
                    <?= renderFieldError($errors, 'days') ?>
                </fieldset>

                <?php /* Aceptación del tratamiento de datos (checkbox obligatorio). */ ?>
                <div class="<?= fieldClass($errors, 'privacy', 'field-wide') ?>">
                    <label class="choice">
                        <input type="checkbox" name="privacy" value="yes"<?= $values['privacy'] ? ' checked' : '' ?>>
                        Acepto el tratamiento de mis datos
                    </label>
                    <?= renderFieldError($errors, 'privacy') ?>
                </div>
            </div>

            <?php /* Botón de envío: manda los datos por POST a este mismo fichero. */ ?>
            <div class="form-actions">
                <button class="button" type="submit">Registrarme</button>
            </div>
        </form>
    <?php endif; ?>
</main>
<?php /* Capa inferior del layout: pie de página y cierre del documento. */ ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
