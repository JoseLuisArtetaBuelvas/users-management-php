<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetUniversidadByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface GetUniversidadByIdUseCase
{
    public function execute(GetUniversidadByIdQuery $query): UniversidadModel;
}
