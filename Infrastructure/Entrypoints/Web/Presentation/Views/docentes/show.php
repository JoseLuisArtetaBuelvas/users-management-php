<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<?php $e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>

<h1>Detalle de docente</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= $e($message) ?></div>
<?php endif; ?>

<table class="detail-table">
    <tr><th>ID</th><td class="col-id"><?= $e($docente->getId()) ?></td></tr>
    <tr><th>Nombre</th><td><?= $e($docente->getNombre()) ?></td></tr>
    <tr><th>Apellidos</th><td><?= $e($docente->getApellidos()) ?></td></tr>
    <tr><th>Correo</th><td><?= $e($docente->getEmail()) ?></td></tr>
    <tr><th>Teléfono</th><td><?= $e($docente->getTelefono()) ?></td></tr>
    <tr>
        <th>Blog</th>
        <td>
            <?php if ($docente->getBlog() !== ''): ?>
                <a href="<?= $e($docente->getBlog()) ?>" target="_blank" rel="noopener noreferrer"><?= $e($docente->getBlog()) ?></a>
            <?php else: ?>
                <em>Sin blog</em>
            <?php endif; ?>
        </td>
    </tr>
    <tr><th>Profesional</th><td><?= $e($docente->getProfesional()) ?></td></tr>
    <tr><th>Escalafón</th><td><?= $e($docente->getEscalafon()) ?></td></tr>
    <tr><th>Idioma</th><td><?= $e($docente->getIdioma()) ?></td></tr>
    <tr>
        <th>Experiencia</th>
        <td>
            <?= $docente->getAniosExperiencia() ?> año(s)
            <?php if ($docente->isExperimentado()): ?><span class="badge">Experimentado</span><?php endif; ?>
        </td>
    </tr>
    <tr><th>Área de trabajo</th><td><?= $e($docente->getAreaTrabajo()) ?></td></tr>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=docentes.edit&amp;id=<?= urlencode($docente->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=docentes.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
