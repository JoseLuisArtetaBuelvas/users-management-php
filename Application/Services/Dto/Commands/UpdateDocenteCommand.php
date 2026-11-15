<?php

declare(strict_types=1);

/**
 * Comando (CQRS) con los datos para actualizar un docente existente.
 */
final class UpdateDocenteCommand
{
    private string $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $telefono;
    private string $blog;
    private string $profesional;
    private string $escalafon;
    private string $idioma;
    private string $aniosExperiencia;
    private string $areaTrabajo;

    public function __construct(
        string $id,
        string $nombre,
        string $apellidos,
        string $email,
        string $telefono,
        string $blog,
        string $profesional,
        string $escalafon,
        string $idioma,
        string $aniosExperiencia,
        string $areaTrabajo
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->apellidos = trim($apellidos);
        $this->email = trim($email);
        $this->telefono = trim($telefono);
        $this->blog = trim($blog);
        $this->profesional = trim($profesional);
        $this->escalafon = trim($escalafon);
        $this->idioma = trim($idioma);
        $this->aniosExperiencia = trim($aniosExperiencia);
        $this->areaTrabajo = trim($areaTrabajo);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getBlog(): string
    {
        return $this->blog;
    }

    public function getProfesional(): string
    {
        return $this->profesional;
    }

    public function getEscalafon(): string
    {
        return $this->escalafon;
    }

    public function getIdioma(): string
    {
        return $this->idioma;
    }

    public function getAniosExperiencia(): string
    {
        return $this->aniosExperiencia;
    }

    public function getAreaTrabajo(): string
    {
        return $this->areaTrabajo;
    }
}
