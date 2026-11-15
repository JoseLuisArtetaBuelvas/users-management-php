<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface SaveUniversidadPort
{
    public function save(UniversidadModel $universidad): UniversidadModel;
}
