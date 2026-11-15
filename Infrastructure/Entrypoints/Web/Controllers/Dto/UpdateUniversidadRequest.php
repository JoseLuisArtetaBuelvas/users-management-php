<?php

declare(strict_types=1);

/**
 * Datos del formulario web para actualizar una universidad.
 */
final class UpdateUniversidadWebRequest
{
    private string $id;
    private string $nombre;
    private string $categoria;
    private string $web;
    private string $rector;
    private string $email;
    private string $acceso;
    private string $telefono;
    private string $ciudad;
    private string $numeroCarreras;
    private string $numSedes;

    public function __construct(
        string $id,
        string $nombre,
        string $categoria,
        string $web,
        string $rector,
        string $email,
        string $acceso,
        string $telefono,
        string $ciudad,
        string $numeroCarreras,
        string $numSedes
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->categoria = trim($categoria);
        $this->web = trim($web);
        $this->rector = trim($rector);
        $this->email = trim($email);
        $this->acceso = trim($acceso);
        $this->telefono = trim($telefono);
        $this->ciudad = trim($ciudad);
        $this->numeroCarreras = trim($numeroCarreras);
        $this->numSedes = trim($numSedes);
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

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    public function getNumeroCarreras(): string
    {
        return $this->numeroCarreras;
    }

    public function getNumSedes(): string
    {
        return $this->numSedes;
    }
}
