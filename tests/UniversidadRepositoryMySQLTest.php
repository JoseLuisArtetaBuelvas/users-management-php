<?php

declare(strict_types=1);

/**
 * Prueba de integración del adaptador UniversidadRepositoryMySQL.
 * Usa la base configurada en .env (MySQL/MariaDB o PostgreSQL según DB_DRIVER).
 * Requiere haber ejecutado el script 03_universidades.sql correspondiente.
 *
 * Ejecutar desde la raíz del proyecto:  php tests/UniversidadRepositoryMySQLTest.php
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

$create = DependencyInjection::getCreateUniversidadUseCase();
$update = DependencyInjection::getUpdateUniversidadUseCase();
$getById = DependencyInjection::getGetUniversidadByIdUseCase();
$getAll = DependencyInjection::getGetAllUniversidadesUseCase();
$delete = DependencyInjection::getDeleteUniversidadUseCase();

$id = 'test-' . bin2hex(random_bytes(6));
$nombre = 'Universidad Prueba ' . substr($id, 5);
$email = $id . '@prueba.edu.co';

$creada = $create->execute(new CreateUniversidadCommand(
    $id, $nombre, 'PRIVADA', 'https://prueba.edu.co', 'Rector de Prueba', $email,
    'EXAMEN_ADMISION', '6050000000', 'Montería', '10', '1'
));
check('INSERT y lectura de la universidad', $creada->id()->value() === $id);

check('SELECT por id', $getById->execute(new GetUniversidadByIdQuery($id))->email()->value() === $email);

$encontradas = $getAll->execute(new GetAllUniversidadesQuery('MONTERÍA'));
check('Búsqueda sin distinguir mayúsculas encuentra la universidad', count(array_filter(
    $encontradas,
    fn(UniversidadModel $u) => $u->id()->value() === $id
)) === 1);

try {
    $create->execute(new CreateUniversidadCommand(
        'otro-' . $id, mb_strtoupper($nombre), 'PRIVADA', 'https://otra.edu.co', 'Otro Rector', 'otro-' . $email,
        'MIXTO', '6050000000', 'Montería', '5', '1'
    ));
    check('Nombre repetido (en mayúsculas) se rechaza', false);
} catch (UniversidadAlreadyExistsException $e) {
    check('Nombre repetido (en mayúsculas) se rechaza', true);
}

$actualizada = $update->execute(new UpdateUniversidadCommand(
    $id, $nombre, 'PUBLICA', 'https://prueba.edu.co', 'Nueva Rectora', $email,
    'MIXTO', '6050000000', 'Montería', '12', '3'
));
check('UPDATE de categoría, rector y sedes', $actualizada->categoria() === 'PUBLICA'
    && $actualizada->rector()->value() === 'Nueva Rectora'
    && $actualizada->numSedes()->value() === 3);

$delete->execute(new DeleteUniversidadCommand($id));
try {
    $getById->execute(new GetUniversidadByIdQuery($id));
    check('DELETE elimina el registro', false);
} catch (UniversidadNotFoundException $e) {
    check('DELETE elimina el registro', true);
}

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
