<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetDocenteByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface GetDocenteByIdUseCase
{
    public function execute(GetDocenteByIdQuery $query): DocenteModel;
}
