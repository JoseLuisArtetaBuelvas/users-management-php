<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateDocenteCommand.php';
require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface CreateDocenteUseCase
{
    public function execute(CreateDocenteCommand $command): DocenteModel;
}
