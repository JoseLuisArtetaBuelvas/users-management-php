<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateUniversidadCommand.php';
require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

interface UpdateUniversidadUseCase
{
    public function execute(UpdateUniversidadCommand $command): UniversidadModel;
}
