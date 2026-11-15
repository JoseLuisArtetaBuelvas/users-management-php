<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<?php $e = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>

<h1>Lista de universidades</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= $e($message) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= $e($success) ?></div>
<?php endif; ?>

<form method="GET" class="search-form">
    <input type="hidden" name="route" value="universidades.index">
    <input type="text" name="q" placeholder="Buscar por nombre, ciudad, rector o correo"
        value="<?= $e($search ?? '') ?>">
    <button type="submit" class="btn">Buscar</button>
    <?php if (!empty($search)): ?>
        <a class="btn" href="?route=universidades.index">Limpiar</a>
    <?php endif; ?>
    <a class="btn btn-primary" href="?route=universidades.create">+ Registrar universidad</a>
</form>

<?php if (empty($universidades)): ?>
    <p><?= !empty($search) ? 'No hay universidades que coincidan con la búsqueda.' : 'No hay universidades registradas todavía.' ?></p>
<?php else: ?>
    <p><?= count($universidades) ?> universidad(es) encontrada(s).</p>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Ciudad</th>
                <th>Rector(a)</th>
                <th>Acceso</th>
                <th>Carreras</th>
                <th>Sedes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($universidades as $u): ?>
                <tr>
                    <td><?= $e($u->getNombre()) ?></td>
                    <td><?= $e($u->getCategoriaLabel()) ?></td>
                    <td><?= $e($u->getCiudad()) ?></td>
                    <td><?= $e($u->getRector()) ?></td>
                    <td><?= $e($u->getAccesoLabel()) ?></td>
                    <td><?= $u->getNumeroCarreras() ?></td>
                    <td>
                        <?= $u->getNumSedes() ?>
                        <?php if ($u->isMultisede()): ?><span class="badge">Multisede</span><?php endif; ?>
                    </td>
                    <td class="col-actions">
                        <a class="btn btn-sm" href="?route=universidades.show&amp;id=<?= urlencode($u->getId()) ?>">Ver</a>
                        <a class="btn btn-warning btn-sm" href="?route=universidades.edit&amp;id=<?= urlencode($u->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=universidades.delete" style="display:inline;"
                            onsubmit="return confirmDeleteUniversidad(this);"
                            data-name="<?= $e($u->getNombre()) ?>">
                            <input type="hidden" name="id" value="<?= $e($u->getId()) ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
