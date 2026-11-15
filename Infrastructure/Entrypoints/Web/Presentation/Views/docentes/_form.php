<?php
/**
 * Campos del formulario de docente, compartidos por create.php y edit.php.
 *
 * @var array<string, string> $old
 * @var array<string, string> $errors
 * @var string[] $escalafonOptions
 * @var string[] $idiomaOptions
 */

$e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$fieldError = static function (string $field) use ($errors, $e): string {
    return !empty($errors[$field])
        ? '<div class="field-error">' . $e($errors[$field]) . '</div>'
        : '';
};

$textFields = array(
    'nombre' => array('Nombre', 'text', 'Ej: Ana María'),
    'apellidos' => array('Apellidos', 'text', 'Ej: Pérez Gómez'),
    'email' => array('Correo', 'email', 'docente@universidad.edu.co'),
    'telefono' => array('Teléfono', 'tel', '+57 300 123 4567'),
    'blog' => array('Blog (opcional)', 'url', 'https://miblog.com'),
    'profesional' => array('Título profesional', 'text', 'Ej: Ingeniero de Sistemas'),
);
?>

<div class="form-grid">
    <?php foreach ($textFields as $field => [$label, $type, $placeholder]): ?>
        <div class="form-group">
            <label for="<?= $field ?>"><?= $e($label) ?></label><br>
            <input type="<?= $type ?>" id="<?= $field ?>" name="<?= $field ?>"
                placeholder="<?= $e($placeholder) ?>"
                value="<?= $e($old[$field] ?? '') ?>">
            <?= $fieldError($field) ?>
        </div>
    <?php endforeach; ?>

    <div class="form-group">
        <label for="escalafon">Escalafón</label><br>
        <select id="escalafon" name="escalafon">
            <option value="">-- Selecciona --</option>
            <?php foreach ($escalafonOptions as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= (($old['escalafon'] ?? '') === $opt) ? 'selected' : '' ?>><?= $e($opt) ?></option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError('escalafon') ?>
    </div>

    <div class="form-group">
        <label for="idioma">Idioma</label><br>
        <select id="idioma" name="idioma">
            <option value="">-- Selecciona --</option>
            <?php foreach ($idiomaOptions as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= (($old['idioma'] ?? '') === $opt) ? 'selected' : '' ?>><?= $e($opt) ?></option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError('idioma') ?>
    </div>

    <div class="form-group">
        <label for="aniosExperiencia">Años de experiencia</label><br>
        <input type="number" id="aniosExperiencia" name="aniosExperiencia" min="0" max="60"
            value="<?= $e($old['aniosExperiencia'] ?? '') ?>">
        <?= $fieldError('aniosExperiencia') ?>
    </div>

    <div class="form-group">
        <label for="areaTrabajo">Área de trabajo</label><br>
        <input type="text" id="areaTrabajo" name="areaTrabajo" placeholder="Ej: Ingeniería de software"
            value="<?= $e($old['areaTrabajo'] ?? '') ?>">
        <?= $fieldError('areaTrabajo') ?>
    </div>
</div>
