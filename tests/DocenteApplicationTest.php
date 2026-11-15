<?php

declare(strict_types=1);

/**
 * Pruebas de los casos de uso de Docente usando un adaptador en memoria.
 * Demuestra la inversión de dependencias: los servicios solo conocen los
 * puertos de salida, así que se pueden probar sin base de datos.
 *
 * Ejecutar desde la raíz del proyecto:  php tests/DocenteApplicationTest.php
 */

require_once __DIR__ . '/../Application/Services/CreateDocenteService.php';
require_once __DIR__ . '/../Application/Services/UpdateDocenteService.php';
require_once __DIR__ . '/../Application/Services/GetDocenteByIdService.php';
require_once __DIR__ . '/../Application/Services/GetAllDocentesService.php';
require_once __DIR__ . '/../Application/Services/DeleteDocenteService.php';

final class InMemoryDocenteRepository implements
    SaveDocentePort,
    UpdateDocentePort,
    GetDocenteByIdPort,
    GetDocenteByEmailPort,
    GetAllDocentesPort,
    DeleteDocentePort
{
    /** @var array<string, DocenteModel> */
    private array $docentes = array();

    public function save(DocenteModel $docente): DocenteModel
    {
        $this->docentes[$docente->id()->value()] = $docente;
        return $docente;
    }

    public function update(DocenteModel $docente): DocenteModel
    {
        return $this->save($docente);
    }

    public function getById(DocenteId $docenteId): ?DocenteModel
    {
        return $this->docentes[$docenteId->value()] ?? null;
    }

    public function getByEmail(DocenteEmail $email): ?DocenteModel
    {
        foreach ($this->docentes as $docente) {
            if ($docente->email()->equals($email)) {
                return $docente;
            }
        }
        return null;
    }

    public function getAll(?string $search = null): array
    {
        if ($search === null) {
            return array_values($this->docentes);
        }

        return array_values(array_filter(
            $this->docentes,
            fn(DocenteModel $d) => stripos($d->nombreCompleto(), $search) !== false
        ));
    }

    public function delete(DocenteId $docenteId): void
    {
        unset($this->docentes[$docenteId->value()]);
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

function crearComando(string $id, string $nombre, string $email): CreateDocenteCommand
{
    return new CreateDocenteCommand(
        $id, $nombre, 'Arrieta Pérez', $email, '3001234567', '',
        'Ingeniero de Sistemas', 'ASISTENTE', 'ESPANOL', '5', 'Desarrollo web'
    );
}

$repo = new InMemoryDocenteRepository();
$create = new CreateDocenteService($repo, $repo);
$update = new UpdateDocenteService($repo, $repo, $repo);
$getById = new GetDocenteByIdService($repo);
$getAll = new GetAllDocentesService($repo);
$delete = new DeleteDocenteService($repo, $repo);

// Create
$creado = $create->execute(crearComando('d-1', 'John', 'john@udc.edu.co'));
check('Crea el docente d-1', $creado->id()->value() === 'd-1');
$create->execute(crearComando('d-2', 'Laura', 'laura@udc.edu.co'));
expectException('No permite email repetido', DocenteAlreadyExistsException::class,
    fn() => $create->execute(crearComando('d-3', 'Otro', 'JOHN@udc.edu.co')));
expectException('Datos inválidos no llegan al repositorio', InvalidDocenteEmailException::class,
    fn() => $create->execute(crearComando('d-4', 'Mal', 'correo-malo')));

// Read / List
check('Consulta por id', $getById->execute(new GetDocenteByIdQuery('d-1'))->nombre()->value() === 'John');
check('Lista 2 docentes', count($getAll->execute(new GetAllDocentesQuery())) === 2);
check('Busca por nombre', count($getAll->execute(new GetAllDocentesQuery('laura'))) === 1);
expectException('Id inexistente', DocenteNotFoundException::class,
    fn() => $getById->execute(new GetDocenteByIdQuery('no-existe')));

// Update
$actualizado = $update->execute(new UpdateDocenteCommand(
    'd-1', 'John', 'Arrieta Pérez', 'john@udc.edu.co', '3001234567', 'https://john.dev',
    'Magíster en Software', 'TITULAR', 'INGLES', '15', 'Arquitectura de software'
));
check('Actualiza escalafón e idioma', $actualizado->escalafon() === 'TITULAR' && $actualizado->idioma() === 'INGLES');
expectException('No permite tomar el email de otro docente', DocenteAlreadyExistsException::class,
    fn() => $update->execute(new UpdateDocenteCommand(
        'd-1', 'John', 'Arrieta', 'laura@udc.edu.co', '3001234567', '',
        'Ingeniero', 'TITULAR', 'INGLES', '15', 'Arquitectura'
    )));

// Delete
$delete->execute(new DeleteDocenteCommand('d-2'));
check('Elimina d-2', count($getAll->execute(new GetAllDocentesQuery())) === 1);
expectException('Eliminar inexistente', DocenteNotFoundException::class,
    fn() => $delete->execute(new DeleteDocenteCommand('d-2')));

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
