<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllDocentesQuery.php';
require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface GetAllDocentesUseCase
{
    /**
     * @return DocenteModel[]
     */
    public function execute(GetAllDocentesQuery $query): array;
}
