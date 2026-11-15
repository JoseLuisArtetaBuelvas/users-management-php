<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/DocenteId.php';

interface GetDocenteByIdPort
{
    public function getById(DocenteId $docenteId): ?DocenteModel;
}
