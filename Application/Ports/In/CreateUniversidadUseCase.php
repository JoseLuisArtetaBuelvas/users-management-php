<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateUniversidadCommand.php';
require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface CreateUniversidadUseCase
{
    public function execute(CreateUniversidadCommand $command): UniversidadModel;
}
