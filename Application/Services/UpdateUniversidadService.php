<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateUniversidadUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateUniversidadPort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByNombrePort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByEmailPort.php';
require_once __DIR__ . '/Mappers/UniversidadApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/UniversidadAlreadyExistsException.php';
require_once __DIR__ . '/../../Domain/Exceptions/UniversidadNotFoundException.php';

/**
 * Caso de uso: actualizar una universidad existente.
 * Verifica que exista y que el nuevo nombre o email no pertenezcan a otra.
 */
final class UpdateUniversidadService implements UpdateUniversidadUseCase
{
    public function __construct(
        private UpdateUniversidadPort $updateUniversidadPort,
        private GetUniversidadByIdPort $getUniversidadByIdPort,
        private GetUniversidadByNombrePort $getUniversidadByNombrePort,
        private GetUniversidadByEmailPort $getUniversidadByEmailPort
    ) {
    }

    public function execute(UpdateUniversidadCommand $command): UniversidadModel
    {
        $universidad = UniversidadApplicationMapper::fromUpdateCommandToModel($command);
        $id = $universidad->id();

        if ($this->getUniversidadByIdPort->getById($id) === null) {
            throw UniversidadNotFoundException::becauseIdWasNotFound($id->value());
        }

        $mismoNombre = $this->getUniversidadByNombrePort->getByNombre($universidad->nombre());
        if ($mismoNombre !== null && !$mismoNombre->id()->equals($id)) {
            throw UniversidadAlreadyExistsException::becauseNombreAlreadyExists($universidad->nombre()->value());
        }

        $mismoEmail = $this->getUniversidadByEmailPort->getByEmail($universidad->email());
        if ($mismoEmail !== null && !$mismoEmail->id()->equals($id)) {
            throw UniversidadAlreadyExistsException::becauseEmailAlreadyExists($universidad->email()->value());
        }

        return $this->updateUniversidadPort->update($universidad);
    }
}
