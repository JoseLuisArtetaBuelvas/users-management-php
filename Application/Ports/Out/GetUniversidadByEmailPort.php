<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/UniversidadEmail.php';

interface GetUniversidadByEmailPort
{
    public function getByEmail(UniversidadEmail $email): ?UniversidadModel;
}
