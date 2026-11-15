<?php

declare(strict_types=1);

/**
 * Prueba de integración del adaptador DocenteRepositoryMySQL.
 * Requiere la BD creada con database/01_crud_usuarios.sql y database/02_docentes.sql
 * y el archivo .env configurado.
 *
 * Ejecutar desde la raíz del proyecto:  php tests/DocenteRepositoryMySQLTest.php
 */

require_once __DIR__ . '/../Common/DependencyInjection.php';

DependencyInjection::boot();

$passed = 0;
$failed = 0;

function check(string $description, bool $condition): void
{
    global $passed, $failed;
    $condition ? $passed++ : $failed++;
    echo ($condition ? '[OK]    ' : '[FALLA] ') . $description . "\n";
}

$create = DependencyInjection::getCreateDocenteUseCase();
$update = DependencyInjection::getUpdateDocenteUseCase();
$getById = DependencyInjection::getGetDocenteByIdUseCase();
$getAll = DependencyInjection::getGetAllDocentesUseCase();
$delete = DependencyInjection::getDeleteDocenteUseCase();

$id = 'test-' . bin2hex(random_bytes(6));
$email = $id . '@prueba.edu.co';

$creado = $create->execute(new CreateDocenteCommand(
    $id, 'Prueba', 'Integración Test', $email, '3000000000', '',
    'Licenciado en Matemáticas', 'AUXILIAR', 'ESPANOL', '1', 'Ciencias básicas'
));
check('INSERT y lectura del docente', $creado->id()->value() === $id);
check('Blog vacío se guarda como NULL y vuelve vacío', $creado->blog()->isEmpty());

$leido = $getById->execute(new GetDocenteByIdQuery($id));
check('SELECT por id', $leido->email()->value() === $email);

$buscados = $getAll->execute(new GetAllDocentesQuery('Integración'));
check('Búsqueda con LIKE encuentra el docente', count(array_filter(
    $buscados,
    fn(DocenteModel $d) => $d->id()->value() === $id
)) === 1);

$actualizado = $update->execute(new UpdateDocenteCommand(
    $id, 'Prueba', 'Integración Test', $email, '3000000000', 'https://blog.prueba.co',
    'Magíster en Matemáticas', 'ASISTENTE', 'FRANCES', '4', 'Ciencias básicas'
));
check('UPDATE de escalafón, idioma y blog', $actualizado->escalafon() === 'ASISTENTE'
    && $actualizado->idioma() === 'FRANCES'
    && $actualizado->blog()->value() === 'https://blog.prueba.co');

$delete->execute(new DeleteDocenteCommand($id));
try {
    $getById->execute(new GetDocenteByIdQuery($id));
    check('DELETE elimina el registro', false);
} catch (DocenteNotFoundException $e) {
    check('DELETE elimina el registro', true);
}

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
