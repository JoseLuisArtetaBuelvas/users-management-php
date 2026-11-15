<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteDocenteCommand.php';
require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

interface DeleteDocenteUseCase
{
    public function execute(DeleteDocenteCommand $command): void;
}
