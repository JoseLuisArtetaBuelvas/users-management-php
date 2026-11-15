<?php

declare(strict_types=1);

/**
 * Datos de la universidad que se envían a las vistas (solo lectura).
 */
final class UniversidadResponse
{
    public function __construct(
        private string $id,
        private string $nombre,
        private string $categoria,
        private string $categoriaLabel,
        private string $web,
        private string $rector,
        private string $email,
        private string $acceso,
        private string $accesoLabel,
        private string $telefono,
        private string $ciudad,
        private int $numeroCarreras,
        private int $numSedes,
        private bool $multisede,
        private float $carrerasPorSede
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

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getCategoriaLabel(): string
    {
        return $this->categoriaLabel;
    }

    public function getWeb(): string
    {
        return $this->web;
    }

    public function getRector(): string
    {
        return $this->rector;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAcceso(): string
    {
        return $this->acceso;
    }

    public function getAccesoLabel(): string
    {
        return $this->accesoLabel;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    public function getNumeroCarreras(): int
    {
        return $this->numeroCarreras;
    }

    public function getNumSedes(): int
    {
        return $this->numSedes;
    }

    public function isMultisede(): bool
    {
        return $this->multisede;
    }

    public function getCarrerasPorSede(): float
    {
        return $this->carrerasPorSede;
    }

    /**
     * @return array<string, string>
     */
    public function toFormArray(): array
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'categoria' => $this->categoria,
            'web' => $this->web,
            'rector' => $this->rector,
            'email' => $this->email,
            'acceso' => $this->acceso,
            'telefono' => $this->telefono,
            'ciudad' => $this->ciudad,
            'numeroCarreras' => (string) $this->numeroCarreras,
            'numSedes' => (string) $this->numSedes,
        );
    }
}
