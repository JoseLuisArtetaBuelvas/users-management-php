<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateDocenteCommand.php';
require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface UpdateDocenteUseCase
{
    public function execute(UpdateDocenteCommand $command): DocenteModel;
}
