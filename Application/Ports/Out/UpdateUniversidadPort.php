<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface UpdateUniversidadPort
{
    public function update(UniversidadModel $universidad): UniversidadModel;
}
