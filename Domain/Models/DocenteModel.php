<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/DocenteId.php';
require_once __DIR__ . '/../ValueObjects/DocenteNombre.php';
require_once __DIR__ . '/../ValueObjects/DocenteEmail.php';
require_once __DIR__ . '/../ValueObjects/DocenteTelefono.php';
require_once __DIR__ . '/../ValueObjects/DocenteBlog.php';
require_once __DIR__ . '/../ValueObjects/DocenteCampoTexto.php';
require_once __DIR__ . '/../ValueObjects/DocenteAniosExperiencia.php';
require_once __DIR__ . '/../Enums/DocenteEscalafonEnum.php';
require_once __DIR__ . '/../Enums/DocenteIdiomaEnum.php';

/**
 * Modelo de dominio Docente (ejercicio 3).
 * Es inmutable: cada cambio devuelve una nueva instancia válida.
 */
final class DocenteModel
{
    private DocenteId $id;
    private DocenteNombre $nombre;
    private DocenteNombre $apellidos;
    private DocenteEmail $email;
    private DocenteTelefono $telefono;
    private DocenteBlog $blog;
    private DocenteCampoTexto $profesional;
    private string $escalafon;
    private string $idioma;
    private DocenteAniosExperiencia $aniosExperiencia;
    private DocenteCampoTexto $areaTrabajo;

    public function __construct(
        DocenteId $id,
        DocenteNombre $nombre,
        DocenteNombre $apellidos,
        DocenteEmail $email,
        DocenteTelefono $telefono,
        DocenteBlog $blog,
        DocenteCampoTexto $profesional,
        string $escalafon,
        string $idioma,
        DocenteAniosExperiencia $aniosExperiencia,
        DocenteCampoTexto $areaTrabajo
    ) {
        DocenteEscalafonEnum::ensureIsValid($escalafon);
        DocenteIdiomaEnum::ensureIsValid($idioma);

        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->blog = $blog;
        $this->profesional = $profesional;
        $this->escalafon = $escalafon;
        $this->idioma = $idioma;
        $this->aniosExperiencia = $aniosExperiencia;
        $this->areaTrabajo = $areaTrabajo;
    }

    public function id(): DocenteId
    {
        return $this->id;
    }

    public function nombre(): DocenteNombre
    {
        return $this->nombre;
    }

    public function apellidos(): DocenteNombre
    {
        return $this->apellidos;
    }

    public function nombreCompleto(): string
    {
        return $this->nombre->value() . ' ' . $this->apellidos->value();
    }

    public function email(): DocenteEmail
    {
        return $this->email;
    }

    public function telefono(): DocenteTelefono
    {
        return $this->telefono;
    }

    public function blog(): DocenteBlog
    {
        return $this->blog;
    }

    public function profesional(): DocenteCampoTexto
    {
        return $this->profesional;
    }

    public function escalafon(): string
    {
        return $this->escalafon;
    }

    public function idioma(): string
    {
        return $this->idioma;
    }

    public function aniosExperiencia(): DocenteAniosExperiencia
    {
        return $this->aniosExperiencia;
    }

    public function areaTrabajo(): DocenteCampoTexto
    {
        return $this->areaTrabajo;
    }

    /**
     * Regla de negocio: un docente con 10 o más años de experiencia
     * se considera docente experimentado.
     */
    public function esExperimentado(): bool
    {
        return $this->aniosExperiencia->value() >= 10;
    }

    public function cambiarEscalafon(string $escalafon): self
    {
        return new self(
            $this->id,
            $this->nombre,
            $this->apellidos,
            $this->email,
            $this->telefono,
            $this->blog,
            $this->profesional,
            $escalafon,
            $this->idioma,
            $this->aniosExperiencia,
            $this->areaTrabajo
        );
    }

    public function cambiarEmail(DocenteEmail $email): self
    {
        return new self(
            $this->id,
            $this->nombre,
            $this->apellidos,
            $email,
            $this->telefono,
            $this->blog,
            $this->profesional,
            $this->escalafon,
            $this->idioma,
            $this->aniosExperiencia,
            $this->areaTrabajo
        );
    }

    /**
     * @return array<string, string|int>
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->id->value(),
            'nombre' => $this->nombre->value(),
            'apellidos' => $this->apellidos->value(),
            'email' => $this->email->value(),
            'telefono' => $this->telefono->value(),
            'blog' => $this->blog->value(),
            'profesional' => $this->profesional->value(),
            'escalafon' => $this->escalafon,
            'idioma' => $this->idioma,
            'aniosExperiencia' => $this->aniosExperiencia->value(),
            'areaTrabajo' => $this->areaTrabajo->value(),
        );
    }
}
