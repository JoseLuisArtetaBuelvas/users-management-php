<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface SaveDocentePort
{
    public function save(DocenteModel $docente): DocenteModel;
}
