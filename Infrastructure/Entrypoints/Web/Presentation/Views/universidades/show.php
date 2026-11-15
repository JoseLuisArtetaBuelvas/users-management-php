<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<?php $e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>

<h1>Detalle de universidad</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= $e($message) ?></div>
<?php endif; ?>

<table class="detail-table">
    <tr><th>ID</th><td class="col-id"><?= $e($universidad->getId()) ?></td></tr>
    <tr><th>Nombre</th><td><?= $e($universidad->getNombre()) ?></td></tr>
    <tr><th>Categoría</th><td><?= $e($universidad->getCategoriaLabel()) ?></td></tr>
    <tr>
        <th>Sitio web</th>
        <td><a href="<?= $e($universidad->getWeb()) ?>" target="_blank" rel="noopener noreferrer"><?= $e($universidad->getWeb()) ?></a></td>
    </tr>
    <tr><th>Rector(a)</th><td><?= $e($universidad->getRector()) ?></td></tr>
    <tr><th>Correo</th><td><?= $e($universidad->getEmail()) ?></td></tr>
    <tr><th>Acceso</th><td><?= $e($universidad->getAccesoLabel()) ?></td></tr>
    <tr><th>Teléfono</th><td><?= $e($universidad->getTelefono()) ?></td></tr>
    <tr><th>Ciudad</th><td><?= $e($universidad->getCiudad()) ?></td></tr>
    <tr><th>Carreras</th><td><?= $universidad->getNumeroCarreras() ?></td></tr>
    <tr>
        <th>Sedes</th>
        <td>
            <?= $universidad->getNumSedes() ?>
            <?php if ($universidad->isMultisede()): ?><span class="badge">Multisede</span><?php endif; ?>
        </td>
    </tr>
    <tr><th>Carreras por sede</th><td><?= number_format($universidad->getCarrerasPorSede(), 1, ',', '.') ?></td></tr>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=universidades.edit&amp;id=<?= urlencode($universidad->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=universidades.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
