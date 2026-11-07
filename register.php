<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$rules = $config['rules'];

// Un único fichero: con GET se pinta el formulario vacío; con POST se valida y se vuelve a pintar.
$isPost     = $_SERVER['REQUEST_METHOD'] === 'POST';
$values     = readRegistrationInput($isPost ? $_POST : []);
$errors     = $isPost ? validateRegistration($values, $sports, $levels, $trainingDays, $rules) : [];
$registered = $isPost && $errors === [];

// Las contraseñas ya se han comprobado: se descartan para que nunca lleguen al HTML.
unset($values['password'], $values['password2']);

// Los controles del formulario siempre reciben arrays "clave => texto".
$sportNames = array_map(static fn(array $sport): string => $sport['name'], $sports);

// Resumen del alta correcta (sin contraseña).
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

$pageTitle = 'Registro';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>
<main class="container">
    <h1>Registro de deportista</h1>

    <?php if ($registered): ?>
        <div class="alert alert-success" role="status">
            <strong>¡Registro correcto, <?= e($values['fullname']) ?>!</strong>
            Tus datos son válidos. De momento no se almacenan: el alta definitiva llegará en un paso posterior.
        </div>

        <section class="card">
            <h2>Resumen de tus datos</h2>
            <dl class="summary">
                <?php foreach ($summary as $label => $value): ?>
                    <dt><?= e($label) ?></dt>
                    <dd><?= e($value) ?></dd>
                <?php endforeach; ?>
            </dl>
            <p><a class="button" href="register.php">Volver al formulario</a></p>
        </section>
    <?php else: ?>
        <p class="lead">Crea tu perfil de deportista. Todos los campos son obligatorios.</p>

        <?php if ($errors !== []): ?>
            <div class="alert alert-error" role="alert">
                <strong>Revisa el formulario: hay <?= count($errors) ?> error(es).</strong>
                <ul>
                    <?php foreach ($errors as $message): ?>
                        <li><?= e($message) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php /* novalidate: desactiva los avisos del navegador para que la validación que cuenta, la del servidor, se vea siempre. */ ?>
        <form class="form" method="post" action="register.php" novalidate>
            <div class="form-grid">
                <div class="<?= fieldClass($errors, 'fullname') ?>">
                    <label for="fullname">Nombre completo</label>
                    <input type="text" id="fullname" name="fullname" value="<?= e($values['fullname']) ?>"
                           minlength="<?= $rules['name_min'] ?>" maxlength="<?= $rules['name_max'] ?>" required>
                    <?= renderFieldError($errors, 'fullname') ?>
                </div>

                <div class="<?= fieldClass($errors, 'username') ?>">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" value="<?= e($values['username']) ?>"
                           pattern="[A-Za-z0-9_]{<?= $rules['username_min'] ?>,<?= $rules['username_max'] ?>}"
                           autocomplete="username" required>
                    <p class="field-hint">Letras, números y guion bajo (_). Entre <?= $rules['username_min'] ?> y <?= $rules['username_max'] ?> caracteres.</p>
                    <?= renderFieldError($errors, 'username') ?>
                </div>

                <div class="<?= fieldClass($errors, 'email') ?>">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= e($values['email']) ?>"
                           autocomplete="email" required>
                    <?= renderFieldError($errors, 'email') ?>
                </div>

                <div class="<?= fieldClass($errors, 'age') ?>">
                    <label for="age">Edad</label>
                    <input type="number" id="age" name="age" value="<?= e($values['age']) ?>"
                           min="<?= $rules['age_min'] ?>" max="<?= $rules['age_max'] ?>" required>
                    <?= renderFieldError($errors, 'age') ?>
                </div>

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

                <div class="<?= fieldClass($errors, 'sport', 'field-wide') ?>">
                    <label for="sport">Deporte principal</label>
                    <select id="sport" name="sport" required>
                        <?= renderOptions($sportNames, $values['sport']) ?>
                    </select>
                    <?= renderFieldError($errors, 'sport') ?>
                </div>

                <fieldset class="<?= fieldClass($errors, 'level', 'field-wide') ?>">
                    <legend>Nivel competitivo</legend>
                    <div class="choices">
                        <?= renderRadioGroup('level', $levels, $values['level']) ?>
                    </div>
                    <?= renderFieldError($errors, 'level') ?>
                </fieldset>

                <fieldset class="<?= fieldClass($errors, 'days', 'field-wide') ?>">
                    <legend>Días de entrenamiento</legend>
                    <div class="choices">
                        <?= renderCheckboxGroup('days', $trainingDays, $values['days']) ?>
                    </div>
                    <?= renderFieldError($errors, 'days') ?>
                </fieldset>

                <div class="<?= fieldClass($errors, 'privacy', 'field-wide') ?>">
                    <label class="choice">
                        <input type="checkbox" name="privacy" value="yes"<?= $values['privacy'] ? ' checked' : '' ?>>
                        Acepto el tratamiento de mis datos
                    </label>
                    <?= renderFieldError($errors, 'privacy') ?>
                </div>
            </div>

            <div class="form-actions">
                <button class="button" type="submit">Registrarme</button>
            </div>
        </form>
    <?php endif; ?>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
