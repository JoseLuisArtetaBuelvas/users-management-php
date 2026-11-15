<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/UniversidadNombre.php';

interface GetUniversidadByNombrePort
{
    public function getByNombre(UniversidadNombre $nombre): ?UniversidadModel;
}
