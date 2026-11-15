<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/UniversidadId.php';
require_once __DIR__ . '/../ValueObjects/UniversidadNombre.php';
require_once __DIR__ . '/../ValueObjects/UniversidadNombrePropio.php';
require_once __DIR__ . '/../ValueObjects/UniversidadWeb.php';
require_once __DIR__ . '/../ValueObjects/UniversidadEmail.php';
require_once __DIR__ . '/../ValueObjects/UniversidadTelefono.php';
require_once __DIR__ . '/../ValueObjects/UniversidadCantidad.php';
require_once __DIR__ . '/../Enums/UniversidadCategoriaEnum.php';
require_once __DIR__ . '/../Enums/UniversidadAccesoEnum.php';

/**
 * Modelo de dominio Universidad (ejercicio 2).
 * Es inmutable: cada cambio devuelve una nueva instancia válida.
 */
final class UniversidadModel
{
    private UniversidadId $id;
    private UniversidadNombre $nombre;
    private string $categoria;
    private UniversidadWeb $web;
    private UniversidadNombrePropio $rector;
    private UniversidadEmail $email;
    private string $acceso;
    private UniversidadTelefono $telefono;
    private UniversidadNombrePropio $ciudad;
    private UniversidadCantidad $numeroCarreras;
    private UniversidadCantidad $numSedes;

    public function __construct(
        UniversidadId $id,
        UniversidadNombre $nombre,
        string $categoria,
        UniversidadWeb $web,
        UniversidadNombrePropio $rector,
        UniversidadEmail $email,
        string $acceso,
        UniversidadTelefono $telefono,
        UniversidadNombrePropio $ciudad,
        UniversidadCantidad $numeroCarreras,
        UniversidadCantidad $numSedes
    ) {
        UniversidadCategoriaEnum::ensureIsValid($categoria);
        UniversidadAccesoEnum::ensureIsValid($acceso);

        $this->id = $id;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->web = $web;
        $this->rector = $rector;
        $this->email = $email;
        $this->acceso = $acceso;
        $this->telefono = $telefono;
        $this->ciudad = $ciudad;
        $this->numeroCarreras = $numeroCarreras;
        $this->numSedes = $numSedes;
    }

    public function id(): UniversidadId
    {
        return $this->id;
    }

    public function nombre(): UniversidadNombre
    {
        return $this->nombre;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function web(): UniversidadWeb
    {
        return $this->web;
    }

    public function rector(): UniversidadNombrePropio
    {
        return $this->rector;
    }

    public function email(): UniversidadEmail
    {
        return $this->email;
    }

    public function acceso(): string
    {
        return $this->acceso;
    }

    public function telefono(): UniversidadTelefono
    {
        return $this->telefono;
    }

    public function ciudad(): UniversidadNombrePropio
    {
        return $this->ciudad;
    }

    public function numeroCarreras(): UniversidadCantidad
    {
        return $this->numeroCarreras;
    }

    public function numSedes(): UniversidadCantidad
    {
        return $this->numSedes;
    }

    public function esPublica(): bool
    {
        return $this->categoria === UniversidadCategoriaEnum::PUBLICA;
    }

    /**
     * Regla de negocio: una universidad con más de una sede es multisede.
     */
    public function esMultisede(): bool
    {
        return $this->numSedes->value() > 1;
    }

    /**
     * Promedio de carreras por sede, redondeado a un decimal.
     */
    public function carrerasPorSede(): float
    {
        return round($this->numeroCarreras->value() / $this->numSedes->value(), 1);
    }

    public function cambiarRector(UniversidadNombrePropio $rector): self
    {
        return new self(
            $this->id,
            $this->nombre,
            $this->categoria,
            $this->web,
            $rector,
            $this->email,
            $this->acceso,
            $this->telefono,
            $this->ciudad,
            $this->numeroCarreras,
            $this->numSedes
        );
    }

    public function abrirSede(): self
    {
        return new self(
            $this->id,
            $this->nombre,
            $this->categoria,
            $this->web,
            $this->rector,
            $this->email,
            $this->acceso,
            $this->telefono,
            $this->ciudad,
            $this->numeroCarreras,
            UniversidadCantidad::numSedes($this->numSedes->value() + 1)
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
            'categoria' => $this->categoria,
            'web' => $this->web->value(),
            'rector' => $this->rector->value(),
            'email' => $this->email->value(),
            'acceso' => $this->acceso,
            'telefono' => $this->telefono->value(),
            'ciudad' => $this->ciudad->value(),
            'numeroCarreras' => $this->numeroCarreras->value(),
            'numSedes' => $this->numSedes->value(),
        );
    }
}
