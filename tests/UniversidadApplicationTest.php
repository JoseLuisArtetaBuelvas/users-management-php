<?php

declare(strict_types=1);

/**
 * Pruebas de los casos de uso de Universidad con un adaptador en memoria.
 * Demuestra la inversión de dependencias: los servicios solo conocen los
 * puertos de salida, así que se prueban sin base de datos.
 *
 * Ejecutar desde la raíz del proyecto:  php tests/UniversidadApplicationTest.php
 */

require_once __DIR__ . '/../Application/Services/CreateUniversidadService.php';
require_once __DIR__ . '/../Application/Services/UpdateUniversidadService.php';
require_once __DIR__ . '/../Application/Services/GetUniversidadByIdService.php';
require_once __DIR__ . '/../Application/Services/GetAllUniversidadesService.php';
require_once __DIR__ . '/../Application/Services/DeleteUniversidadService.php';

final class InMemoryUniversidadRepository implements
    SaveUniversidadPort,
    UpdateUniversidadPort,
    GetUniversidadByIdPort,
    GetUniversidadByNombrePort,
    GetUniversidadByEmailPort,
    GetAllUniversidadesPort,
    DeleteUniversidadPort
{
    /** @var array<string, UniversidadModel> */
    private array $items = array();

    public function save(UniversidadModel $universidad): UniversidadModel
    {
        $this->items[$universidad->id()->value()] = $universidad;
        return $universidad;
    }

    public function update(UniversidadModel $universidad): UniversidadModel
    {
        return $this->save($universidad);
    }

    public function getById(UniversidadId $universidadId): ?UniversidadModel
    {
        return $this->items[$universidadId->value()] ?? null;
    }

    public function getByNombre(UniversidadNombre $nombre): ?UniversidadModel
    {
        foreach ($this->items as $u) {
            if ($u->nombre()->equals($nombre)) {
                return $u;
            }
        }
        return null;
    }

    public function getByEmail(UniversidadEmail $email): ?UniversidadModel
    {
        foreach ($this->items as $u) {
            if ($u->email()->equals($email)) {
                return $u;
            }
        }
        return null;
    }

    public function getAll(?string $search = null): array
    {
        if ($search === null) {
            return array_values($this->items);
        }

        return array_values(array_filter(
            $this->items,
            fn(UniversidadModel $u) => stripos($u->nombre()->value() . ' ' . $u->ciudad()->value(), $search) !== false
        ));
    }

    public function delete(UniversidadId $universidadId): void
    {
        unset($this->items[$universidadId->value()]);
    }
}

$passed = 0;
$failed = 0;

function check(string $description, bool $condition): void
{
    global $passed, $failed;
    $condition ? $passed++ : $failed++;
    echo ($condition ? '[OK]    ' : '[FALLA] ') . $description . "\n";
}

function expectException(string $description, string $expected, callable $action): void
{
    try {
        $action();
        check($description . ' (no lanzó excepción)', false);
    } catch (Throwable $e) {
        check($description . ' -> ' . get_class($e), $e instanceof $expected);
    }
}

function datos(string $id, string $nombre, string $email, string $ciudad = 'Cartagena'): array
{
    return array($id, $nombre, 'PUBLICA', 'https://www.ejemplo.edu.co', 'Rector de Prueba', $email,
        'PRUEBAS_SABER_11', '6056600676', $ciudad, '30', '2');
}

$repo = new InMemoryUniversidadRepository();
$create = new CreateUniversidadService($repo, $repo, $repo);
$update = new UpdateUniversidadService($repo, $repo, $repo, $repo);
$getById = new GetUniversidadByIdService($repo);
$getAll = new GetAllUniversidadesService($repo);
$delete = new DeleteUniversidadService($repo, $repo);

// Create
$creada = $create->execute(new CreateUniversidadCommand(...datos('u-1', 'Universidad de Cartagena', 'info@udc.edu.co')));
check('Crea la universidad u-1', $creada->id()->value() === 'u-1');
$create->execute(new CreateUniversidadCommand(...datos('u-2', 'Universidad del Norte', 'info@uninorte.edu.co', 'Barranquilla')));
expectException('No permite nombre repetido (sin importar mayúsculas)', UniversidadAlreadyExistsException::class,
    fn() => $create->execute(new CreateUniversidadCommand(...datos('u-3', 'UNIVERSIDAD DE CARTAGENA', 'otro@udc.edu.co'))));
expectException('No permite email repetido', UniversidadAlreadyExistsException::class,
    fn() => $create->execute(new CreateUniversidadCommand(...datos('u-4', 'Otra Universidad', 'INFO@udc.edu.co'))));
expectException('Datos inválidos no llegan al repositorio', InvalidUniversidadWebException::class,
    fn() => $create->execute(new CreateUniversidadCommand('u-5', 'Universidad X', 'PUBLICA', 'sin-url', 'Rector X',
        'x@x.co', 'MIXTO', '6056600676', 'Cartagena', '3', '1')));

// Read / List
check('Consulta por id', $getById->execute(new GetUniversidadByIdQuery('u-1'))->ciudad()->value() === 'Cartagena');
check('Lista 2 universidades', count($getAll->execute(new GetAllUniversidadesQuery())) === 2);
check('Busca por ciudad', count($getAll->execute(new GetAllUniversidadesQuery('barranquilla'))) === 1);
expectException('Id inexistente', UniversidadNotFoundException::class,
    fn() => $getById->execute(new GetUniversidadByIdQuery('no-existe')));

// Update
$datos = datos('u-1', 'Universidad de Cartagena', 'info@udc.edu.co');
$datos[4] = 'Nuevo Rector';
$datos[10] = '6';
$actualizada = $update->execute(new UpdateUniversidadCommand(...$datos));
check('Actualiza rector y sedes', $actualizada->rector()->value() === 'Nuevo Rector' && $actualizada->numSedes()->value() === 6);
expectException('No permite tomar el nombre de otra universidad', UniversidadAlreadyExistsException::class,
    fn() => $update->execute(new UpdateUniversidadCommand(...datos('u-1', 'Universidad del Norte', 'info@udc.edu.co'))));

// Delete
$delete->execute(new DeleteUniversidadCommand('u-2'));
check('Elimina u-2', count($getAll->execute(new GetAllUniversidadesQuery())) === 1);
expectException('Eliminar inexistente', UniversidadNotFoundException::class,
    fn() => $delete->execute(new DeleteUniversidadCommand('u-2')));

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
