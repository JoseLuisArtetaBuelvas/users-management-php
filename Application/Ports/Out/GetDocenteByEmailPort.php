<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/DocenteEmail.php';

interface GetDocenteByEmailPort
{
    public function getByEmail(DocenteEmail $email): ?DocenteModel;
}
