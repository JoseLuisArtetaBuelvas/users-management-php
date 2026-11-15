<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteDocenteUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteDocentePort.php';
require_once __DIR__ . '/../Ports/Out/GetDocenteByIdPort.php';
require_once __DIR__ . '/Mappers/DocenteApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/DocenteNotFoundException.php';

final class DeleteDocenteService implements DeleteDocenteUseCase
{
    private DeleteDocentePort $deleteDocentePort;
    private GetDocenteByIdPort $getDocenteByIdPort;

    public function __construct(
        DeleteDocentePort $deleteDocentePort,
        GetDocenteByIdPort $getDocenteByIdPort
    ) {
        $this->deleteDocentePort = $deleteDocentePort;
        $this->getDocenteByIdPort = $getDocenteByIdPort;
    }

    public function execute(DeleteDocenteCommand $command): void
    {
        $docenteId = DocenteApplicationMapper::fromDeleteCommandToDocenteId($command);

        if ($this->getDocenteByIdPort->getById($docenteId) === null) {
            throw DocenteNotFoundException::becauseIdWasNotFound($docenteId->value());
        }

        $this->deleteDocentePort->delete($docenteId);
    }
}
