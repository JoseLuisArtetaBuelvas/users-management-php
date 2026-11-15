<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface GetAllUniversidadesPort
{
    /**
     * @return UniversidadModel[]
     */
    public function getAll(?string $search = null): array;
}
