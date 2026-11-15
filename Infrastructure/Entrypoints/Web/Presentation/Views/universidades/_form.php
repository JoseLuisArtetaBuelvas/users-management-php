<?php
/**
 * Campos del formulario de universidad, compartidos por create.php y edit.php.
 *
 * @var array<string, string> $old
 * @var array<string, string> $errors
 * @var array<string, string> $categoriaOptions  valor => texto
 * @var array<string, string> $accesoOptions     valor => texto
 */

$e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

$fieldError = static function (string $field) use ($errors, $e): string {
    return !empty($errors[$field])
        ? '<div class="field-error">' . $e($errors[$field]) . '</div>'
        : '';
};

$select = static function (string $field, string $label, array $options) use ($old, $e, $fieldError): string {
    $html = '<div class="form-group"><label for="' . $field . '">' . $e($label) . '</label><br>'
        . '<select id="' . $field . '" name="' . $field . '"><option value="">-- Selecciona --</option>';

    foreach ($options as $value => $text) {
        $selected = (($old[$field] ?? '') === $value) ? ' selected' : '';
        $html .= '<option value="' . $e($value) . '"' . $selected . '>' . $e($text) . '</option>';
    }

    return $html . '</select>' . $fieldError($field) . '</div>';
};

$input = static function (string $field, string $label, string $type, string $placeholder, string $extra = '') use ($old, $e, $fieldError): string {
    return '<div class="form-group"><label for="' . $field . '">' . $e($label) . '</label><br>'
        . '<input type="' . $type . '" id="' . $field . '" name="' . $field . '" placeholder="' . $e($placeholder) . '" '
        . 'value="' . $e($old[$field] ?? '') . '" ' . $extra . '>'
        . $fieldError($field) . '</div>';
};
?>

<div class="form-grid">
    <?= $input('nombre', 'Nombre', 'text', 'Ej: Universidad de Cartagena') ?>
    <?= $select('categoria', 'Categoría', $categoriaOptions) ?>
    <?= $input('web', 'Sitio web', 'url', 'https://www.universidad.edu.co') ?>
    <?= $input('rector', 'Rector(a)', 'text', 'Ej: María Fernanda Ríos') ?>
    <?= $input('email', 'Correo', 'email', 'contacto@universidad.edu.co') ?>
    <?= $select('acceso', 'Modalidad de acceso / admisión', $accesoOptions) ?>
    <?= $input('telefono', 'Teléfono', 'tel', '+57 605 600 1234') ?>
    <?= $input('ciudad', 'Ciudad', 'text', 'Ej: Cartagena') ?>
    <?= $input('numeroCarreras', 'Número de carreras', 'number', '1 a 500', 'min="1" max="500"') ?>
    <?= $input('numSedes', 'Número de sedes', 'number', '1 a 100', 'min="1" max="100"') ?>
</div>
