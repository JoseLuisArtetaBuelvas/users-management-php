<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<?php $e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>

<h1>Lista de docentes</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= $e($message) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= $e($success) ?></div>
<?php endif; ?>

<form method="GET" class="search-form">
    <input type="hidden" name="route" value="docentes.index">
    <input type="text" name="q" placeholder="Buscar por nombre, apellidos, correo o área"
        value="<?= $e($search ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <?php if (!empty($search)): ?>
        <a class="btn" href="?route=docentes.index">Limpiar</a>
    <?php endif; ?>
    <a class="btn btn-primary" href="?route=docentes.create">+ Registrar docente</a>
</form>

<?php if (empty($docentes)): ?>
    <p><?= !empty($search) ? 'No hay docentes que coincidan con la búsqueda.' : 'No hay docentes registrados todavía.' ?></p>
<?php else: ?>
    <p><?= count($docentes) ?> docente(s) encontrado(s).</p>
    <table>
        <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Escalafón</th>
                <th>Idioma</th>
                <th>Experiencia</th>
                <th>Área de trabajo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $docente): ?>
                <tr>
                    <td><?= $e($docente->getNombreCompleto()) ?></td>
                    <td><?= $e($docente->getEmail()) ?></td>
                    <td><?= $e($docente->getTelefono()) ?></td>
                    <td><?= $e($docente->getEscalafon()) ?></td>
                    <td><?= $e($docente->getIdioma()) ?></td>
                    <td>
                        <?= $docente->getAniosExperiencia() ?> año(s)
                        <?php if ($docente->isExperimentado()): ?>
                            <span class="badge">Experimentado</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $e($docente->getAreaTrabajo()) ?></td>
                    <td class="col-actions">
                        <a class="btn btn-sm" href="?route=docentes.show&amp;id=<?= urlencode($docente->getId()) ?>">Ver</a>
                        <a class="btn btn-warning btn-sm" href="?route=docentes.edit&amp;id=<?= urlencode($docente->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=docentes.delete" style="display:inline;"
                            onsubmit="return confirmDeleteDocente(this);"
                            data-name="<?= $e($docente->getNombreCompleto()) ?>">
                            <input type="hidden" name="id" value="<?= $e($docente->getId()) ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
