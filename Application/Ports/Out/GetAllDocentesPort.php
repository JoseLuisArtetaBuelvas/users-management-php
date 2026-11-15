<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface GetAllDocentesPort
{
    /**
     * @return DocenteModel[]
     */
    public function getAll(?string $search = null): array;
}
