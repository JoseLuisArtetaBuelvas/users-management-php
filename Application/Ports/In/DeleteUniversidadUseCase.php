<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteUniversidadCommand.php';
require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface DeleteUniversidadUseCase
{
    public function execute(DeleteUniversidadCommand $command): void;
}
