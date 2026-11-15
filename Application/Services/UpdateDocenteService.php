<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateDocenteUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateDocentePort.php';
require_once __DIR__ . '/../Ports/Out/GetDocenteByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetDocenteByEmailPort.php';
require_once __DIR__ . '/Mappers/DocenteApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/DocenteAlreadyExistsException.php';
require_once __DIR__ . '/../../Domain/Exceptions/DocenteNotFoundException.php';

/**
 * Caso de uso: actualizar un docente existente.
 * Verifica que exista y que el nuevo email no pertenezca a otro docente.
 */
final class UpdateDocenteService implements UpdateDocenteUseCase
{
    private UpdateDocentePort $updateDocentePort;
    private GetDocenteByIdPort $getDocenteByIdPort;
    private GetDocenteByEmailPort $getDocenteByEmailPort;

    public function __construct(
        UpdateDocentePort $updateDocentePort,
        GetDocenteByIdPort $getDocenteByIdPort,
        GetDocenteByEmailPort $getDocenteByEmailPort
    ) {
        $this->updateDocentePort = $updateDocentePort;
        $this->getDocenteByIdPort = $getDocenteByIdPort;
        $this->getDocenteByEmailPort = $getDocenteByEmailPort;
    }

    public function execute(UpdateDocenteCommand $command): DocenteModel
    {
        $docente = DocenteApplicationMapper::fromUpdateCommandToModel($command);

        if ($this->getDocenteByIdPort->getById($docente->id()) === null) {
            throw DocenteNotFoundException::becauseIdWasNotFound($docente->id()->value());
        }

        $docenteConMismoEmail = $this->getDocenteByEmailPort->getByEmail($docente->email());

        if ($docenteConMismoEmail !== null && !$docenteConMismoEmail->id()->equals($docente->id())) {
            throw DocenteAlreadyExistsException::becauseEmailAlreadyExists($docente->email()->value());
        }

        return $this->updateDocentePort->update($docente);
    }
}
