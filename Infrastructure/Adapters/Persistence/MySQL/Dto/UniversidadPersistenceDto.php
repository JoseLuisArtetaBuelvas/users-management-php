<?php

declare(strict_types=1);

/**
 * Datos planos de la universidad listos para persistir (sin reglas de negocio).
 */
final class UniversidadPersistenceDto
{
    public function __construct(
        private string $id,
        private string $nombre,
        private string $categoria,
        private string $web,
        private string $rector,
        private string $email,
        private string $acceso,
        private string $telefono,
        private string $ciudad,
        private int $numeroCarreras,
        private int $numSedes
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

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function web(): string
    {
        return $this->web;
    }

    public function rector(): string
    {
        return $this->rector;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function acceso(): string
    {
        return $this->acceso;
    }

    public function telefono(): string
    {
        return $this->telefono;
    }

    public function ciudad(): string
    {
        return $this->ciudad;
    }

    public function numeroCarreras(): int
    {
        return $this->numeroCarreras;
    }

    public function numSedes(): int
    {
        return $this->numSedes;
    }
}
