<?php

declare(strict_types=1);

/**
 * Pruebas de la capa de dominio de Docente (sin frameworks).
 * Ejecutar desde la raíz del proyecto:  php tests/DocenteDomainTest.php
 */

require_once __DIR__ . '/../Domain/Models/DocenteModel.php';
require_once __DIR__ . '/../Domain/Events/DocenteCreatedDomainEvent.php';
require_once __DIR__ . '/../Domain/Events/DocenteDeletedDomainEvent.php';

$passed = 0;
$failed = 0;

function check(string $description, bool $condition): void
{
    global $passed, $failed;

    if ($condition) {
        $passed++;
        echo "[OK]    {$description}\n";
        return;
    }

    $failed++;
    echo "[FALLA] {$description}\n";
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

function docenteValido(array $overrides = array()): DocenteModel
{
    $data = array_merge(array(
        'nombre' => 'Ana María',
        'apellidos' => 'Pérez Gómez',
        'email' => 'Ana.Perez@Unicartagena.edu.co',
        'telefono' => '+57 300 123 4567',
        'blog' => 'https://anaperez.blog',
        'profesional' => 'Ingeniera de Sistemas',
        'escalafon' => DocenteEscalafonEnum::ASOCIADO,
        'idioma' => DocenteIdiomaEnum::ESPANOL,
        'aniosExperiencia' => '12',
        'areaTrabajo' => 'Desarrollo de software',
    ), $overrides);

    return new DocenteModel(
        new DocenteId('d-001'),
        new DocenteNombre($data['nombre']),
        DocenteNombre::apellidos($data['apellidos']),
        new DocenteEmail($data['email']),
        new DocenteTelefono($data['telefono']),
        new DocenteBlog($data['blog']),
        DocenteCampoTexto::profesional($data['profesional']),
        $data['escalafon'],
        $data['idioma'],
        DocenteAniosExperiencia::fromString($data['aniosExperiencia']),
        DocenteCampoTexto::areaTrabajo($data['areaTrabajo'])
    );
}

// ── Casos válidos ──────────────────────────────────────────────
$docente = docenteValido();
check('Crea un docente válido', $docente instanceof DocenteModel);
check('El email se normaliza a minúsculas', $docente->email()->value() === 'ana.perez@unicartagena.edu.co');
check('Nombre completo = nombre + apellidos', $docente->nombreCompleto() === 'Ana María Pérez Gómez');
check('12 años de experiencia es experimentado', $docente->esExperimentado());
check('El blog es opcional', docenteValido(array('blog' => ''))->blog()->isEmpty());
check('0 años de experiencia es válido', docenteValido(array('aniosExperiencia' => '0'))->aniosExperiencia()->value() === 0);

$ascendido = $docente->cambiarEscalafon(DocenteEscalafonEnum::TITULAR);
check('cambiarEscalafon devuelve una nueva instancia', $ascendido !== $docente);
check('El original no cambia (inmutable)', $docente->escalafon() === DocenteEscalafonEnum::ASOCIADO);
check('La copia tiene el nuevo escalafón', $ascendido->escalafon() === DocenteEscalafonEnum::TITULAR);

$evento = new DocenteCreatedDomainEvent($docente);
check('Evento docente.created con payload', $evento->eventName() === 'docente.created' && $evento->payload()['id'] === 'd-001');
check('Evento docente.deleted', (new DocenteDeletedDomainEvent(new DocenteId('d-001')))->payload() === array('id' => 'd-001'));

// ── Reglas de negocio violadas ─────────────────────────────────
expectException('Id vacío', InvalidDocenteIdException::class, fn() => new DocenteId('  '));
expectException('Nombre vacío', InvalidDocenteNombreException::class, fn() => docenteValido(array('nombre' => '')));
expectException('Nombre con números', InvalidDocenteNombreException::class, fn() => docenteValido(array('nombre' => 'Ana2')));
expectException('Apellidos de 1 letra', InvalidDocenteNombreException::class, fn() => docenteValido(array('apellidos' => 'P')));
expectException('Email inválido', InvalidDocenteEmailException::class, fn() => docenteValido(array('email' => 'ana@')));
expectException('Teléfono con letras', InvalidDocenteTelefonoException::class, fn() => docenteValido(array('telefono' => '300abc4567')));
expectException('Teléfono muy corto', InvalidDocenteTelefonoException::class, fn() => docenteValido(array('telefono' => '12345')));
expectException('Blog sin http(s)', InvalidDocenteBlogException::class, fn() => docenteValido(array('blog' => 'ftp://blog.com')));
expectException('Profesional vacío', InvalidDocenteCampoTextoException::class, fn() => docenteValido(array('profesional' => ' ')));
expectException('Área de trabajo muy corta', InvalidDocenteCampoTextoException::class, fn() => docenteValido(array('areaTrabajo' => 'TI')));
expectException('Escalafón inexistente', InvalidDocenteEscalafonException::class, fn() => docenteValido(array('escalafon' => 'DECANO')));
expectException('Idioma inexistente', InvalidDocenteIdiomaException::class, fn() => docenteValido(array('idioma' => 'KLINGON')));
expectException('Experiencia negativa', InvalidDocenteAniosExperienciaException::class, fn() => docenteValido(array('aniosExperiencia' => '-1')));
expectException('Experiencia mayor a 60', InvalidDocenteAniosExperienciaException::class, fn() => docenteValido(array('aniosExperiencia' => '61')));
expectException('Experiencia no numérica', InvalidDocenteAniosExperienciaException::class, fn() => docenteValido(array('aniosExperiencia' => 'diez')));

echo "\nResultado: {$passed} pruebas OK, {$failed} fallidas.\n";
exit($failed === 0 ? 0 : 1);
