<?php

declare(strict_types=1);

/**
 * Datos del docente que se envían a las vistas (solo lectura).
 */
final class DocenteResponse
{
    public function __construct(
        private string $id,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $telefono,
        private string $blog,
        private string $profesional,
        private string $escalafon,
        private string $idioma,
        private int $aniosExperiencia,
        private string $areaTrabajo,
        private bool $experimentado
    ) {
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

    public function getNombreCompleto(): string
    {
        return $this->nombre . ' ' . $this->apellidos;
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

    public function getAniosExperiencia(): int
    {
        return $this->aniosExperiencia;
    }

    public function getAreaTrabajo(): string
    {
        return $this->areaTrabajo;
    }

    public function isExperimentado(): bool
    {
        return $this->experimentado;
    }

    /**
     * @return array<string, string>
     */
    public function toFormArray(): array
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'blog' => $this->blog,
            'profesional' => $this->profesional,
            'escalafon' => $this->escalafon,
            'idioma' => $this->idioma,
            'aniosExperiencia' => (string) $this->aniosExperiencia,
            'areaTrabajo' => $this->areaTrabajo,
        );
    }
}
