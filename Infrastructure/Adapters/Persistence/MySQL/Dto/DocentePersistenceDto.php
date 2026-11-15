<?php

declare(strict_types=1);

/**
 * Datos planos del docente listos para persistir (sin reglas de negocio).
 */
final class DocentePersistenceDto
{
    public function __construct(
        private string $id,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $telefono,
        private ?string $blog,
        private string $profesional,
        private string $escalafon,
        private string $idioma,
        private int $aniosExperiencia,
        private string $areaTrabajo
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function apellidos(): string
    {
        return $this->apellidos;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function telefono(): string
    {
        return $this->telefono;
    }

    public function blog(): ?string
    {
        return $this->blog;
    }

    public function profesional(): string
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

    public function aniosExperiencia(): int
    {
        return $this->aniosExperiencia;
    }

    public function areaTrabajo(): string
    {
        return $this->areaTrabajo;
    }
}
