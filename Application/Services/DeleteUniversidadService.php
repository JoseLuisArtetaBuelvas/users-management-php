<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteUniversidadUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteUniversidadPort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByIdPort.php';
require_once __DIR__ . '/Mappers/UniversidadApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/UniversidadNotFoundException.php';

final class DeleteUniversidadService implements DeleteUniversidadUseCase
{
    public function __construct(
        private DeleteUniversidadPort $deleteUniversidadPort,
        private GetUniversidadByIdPort $getUniversidadByIdPort
    ) {
    }

    public function execute(DeleteUniversidadCommand $command): void
    {
        $id = UniversidadApplicationMapper::fromDeleteCommandToUniversidadId($command);

        if ($this->getUniversidadByIdPort->getById($id) === null) {
            throw UniversidadNotFoundException::becauseIdWasNotFound($id->value());
        }

        $this->deleteUniversidadPort->delete($id);
    }
}
