<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllUniversidadesQuery.php';
require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface GetAllUniversidadesUseCase
{
    /**
     * @return UniversidadModel[]
     */
    public function execute(GetAllUniversidadesQuery $query): array;
}
