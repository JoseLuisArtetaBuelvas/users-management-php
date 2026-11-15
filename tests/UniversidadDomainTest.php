<?php

declare(strict_types=1);

/**
 * Pruebas de la capa de dominio de Universidad (sin frameworks).
 * Ejecutar desde la raíz del proyecto:  php tests/UniversidadDomainTest.php
 */

require_once __DIR__ . '/../Domain/Models/UniversidadModel.php';
require_once __DIR__ . '/../Domain/Events/UniversidadCreatedDomainEvent.php';
require_once __DIR__ . '/../Domain/Events/UniversidadDeletedDomainEvent.php';

$passed = 0;
$failed = 0;

function check(string $description, bool $condition): void
{
    global $passed, $failed;
    $condition ? $passed++ : $failed++;
    echo ($condition ? '[OK]    ' : '[FALLA] ') . $description . "\n";
}

/**
 * @param class-string<Throwable> $expected
 */
function expectException(string $description, string $expected, callable $action): void
{
    try {
        $action();
        check($description . ' (no lanzó excepción)', false);
    } catch (Throwable $e) {
        check($description . ' -> ' . get_class($e), $e instanceof $expected);
    }
}

function universidadValida(array $overrides = array()): UniversidadModel
{
    $d = array_merge(array(
        'nombre' => 'Universidad de Cartagena',
        'categoria' => UniversidadCategoriaEnum::PUBLICA,
        'web' => 'https://www.unicartagena.edu.co',
        'rector' => 'María Fernanda Ríos',
        'email' => 'Rectoria@Unicartagena.edu.co',
        'acceso' => UniversidadAccesoEnum::PRUEBAS_SABER_11,
        'telefono' => '+57 605 600 1234',
        'ciudad' => 'Cartagena',
        'numeroCarreras' => '42',
        'numSedes' => '5',
    ), $overrides);

    return new UniversidadModel(
        new UniversidadId('u-001'),
        new UniversidadNombre($d['nombre']),
        $d['categoria'],
        new UniversidadWeb($d['web']),
        UniversidadNombrePropio::rector($d['rector']),
        new UniversidadEmail($d['email']),
        $d['acceso'],
        new UniversidadTelefono($d['telefono']),
        UniversidadNombrePropio::ciudad($d['ciudad']),
        UniversidadCantidad::numeroCarrerasFromString($d['numeroCarreras']),
        UniversidadCantidad::numSedesFromString($d['numSedes'])
    );
}

// ── Casos válidos ──────────────────────────────────────────────
$u = universidadValida();
check('Crea una universidad válida', $u instanceof UniversidadModel);
check('El email se normaliza a minúsculas', $u->email()->value() === 'rectoria@unicartagena.edu.co');
check('Es pública', $u->esPublica());
check('Con 5 sedes es multisede', $u->esMultisede());
check('42 carreras / 5 sedes = 8.4 por sede', $u->carrerasPorSede() === 8.4);
check('Con 1 sede no es multisede', !universidadValida(array('numSedes' => '1'))->esMultisede());
check('Label legible del acceso', UniversidadAccesoEnum::label($u->acceso()) === 'Pruebas Saber 11 / ICFES');
check('Nombres iguales sin importar mayúsculas',
    (new UniversidadNombre('Universidad  de Cartagena'))->equals(new UniversidadNombre('universidad de cartagena')));

$nueva = $u->cambiarRector(UniversidadNombrePropio::rector('Ana María Pérez'));
check('cambiarRector devuelve una nueva instancia', $nueva !== $u);
check('El original no cambia (inmutable)', $u->rector()->value() === 'María Fernanda Ríos');
check('abrirSede suma una sede', $u->abrirSede()->numSedes()->value() === 6);

$evento = new UniversidadCreatedDomainEvent($u);
check('Evento universidad.created con payload', $evento->eventName() === 'universidad.created' && $evento->payload()['id'] === 'u-001');
check('Evento universidad.deleted', (new UniversidadDeletedDomainEvent(new UniversidadId('u-001')))->payload() === array('id' => 'u-001'));

// ── Reglas de negocio violadas ─────────────────────────────────
expectException('Id vacío', InvalidUniversidadIdException::class, fn() => new UniversidadId(' '));
expectException('Nombre vacío', InvalidUniversidadNombreException::class, fn() => universidadValida(array('nombre' => '')));
expectException('Nombre de 2 letras', InvalidUniversidadNombreException::class, fn() => universidadValida(array('nombre' => 'UC')));
expectException('Nombre con símbolos', InvalidUniversidadNombreException::class, fn() => universidadValida(array('nombre' => 'Uni#versidad')));
expectException('Categoría inexistente', InvalidUniversidadCategoriaException::class, fn() => universidadValida(array('categoria' => 'MIXTA')));
expectException('Web sin http(s)', InvalidUniversidadWebException::class, fn() => universidadValida(array('web' => 'www.unicartagena.edu.co')));
expectException('Web vacía', InvalidUniversidadWebException::class, fn() => universidadValida(array('web' => '')));
expectException('Rector con números', InvalidUniversidadPersonaException::class, fn() => universidadValida(array('rector' => 'Rector 2026')));
expectException('Email inválido', InvalidUniversidadEmailException::class, fn() => universidadValida(array('email' => 'rectoria@')));
expectException('Acceso inexistente', InvalidUniversidadAccesoException::class, fn() => universidadValida(array('acceso' => 'SORTEO')));
expectException('Teléfono con letras', InvalidUniversidadTelefonoException::class, fn() => universidadValida(array('telefono' => '605abc0676')));
expectException('Ciudad vacía', InvalidUniversidadPersonaException::class, fn() => universidadValida(array('ciudad' => ' ')));
expectException('0 carreras', InvalidUniversidadCantidadException::class, fn() => universidadValida(array('numeroCarreras' => '0')));
expectException('501 carreras', InvalidUniversidadCantidadException::class, fn() => universidadValida(array('numeroCarreras' => '501')));
expectException('0 sedes', InvalidUniversidadCantidadException::class, fn() => universidadValida(array('numSedes' => '0')));
expectException('Sedes no numéricas', InvalidUniversidadCantidadException::class, fn() => universidadValida(array('numSedes' => 'tres')));

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
