<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/UniversidadId.php';

interface DeleteUniversidadPort
{
    public function delete(UniversidadId $universidadId): void;
}
