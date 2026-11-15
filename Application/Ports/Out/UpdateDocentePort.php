<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface UpdateDocentePort
{
    public function update(DocenteModel $docente): DocenteModel;
}
