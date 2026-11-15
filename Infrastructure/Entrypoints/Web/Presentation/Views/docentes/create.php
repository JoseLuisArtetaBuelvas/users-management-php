<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Registrar docente</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="POST" action="?route=docentes.store">
    <?php require __DIR__ . '/_form.php'; ?>

    <button type="submit" class="btn btn-primary">Registrar docente</button>
    &nbsp;
    <a class="btn" href="?route=docentes.index">Cancelar</a>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
