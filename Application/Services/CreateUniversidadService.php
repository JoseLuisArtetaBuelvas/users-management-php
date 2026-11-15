<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateUniversidadUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveUniversidadPort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByNombrePort.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByEmailPort.php';
require_once __DIR__ . '/Mappers/UniversidadApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/UniversidadAlreadyExistsException.php';

/**
 * Caso de uso: registrar una universidad.
 * 1. Construye el modelo (los Value Objects validan cada dato).
 * 2. Verifica que el nombre y el email no estén registrados.
 * 3. Guarda usando el puerto de salida.
 */
final class CreateUniversidadService implements CreateUniversidadUseCase
{
    public function __construct(
        private SaveUniversidadPort $saveUniversidadPort,
        private GetUniversidadByNombrePort $getUniversidadByNombrePort,
        private GetUniversidadByEmailPort $getUniversidadByEmailPort
    ) {
    }

    public function execute(CreateUniversidadCommand $command): UniversidadModel
    {
        $universidad = UniversidadApplicationMapper::fromCreateCommandToModel($command);

        if ($this->getUniversidadByNombrePort->getByNombre($universidad->nombre()) !== null) {
            throw UniversidadAlreadyExistsException::becauseNombreAlreadyExists($universidad->nombre()->value());
        }

        if ($this->getUniversidadByEmailPort->getByEmail($universidad->email()) !== null) {
            throw UniversidadAlreadyExistsException::becauseEmailAlreadyExists($universidad->email()->value());
        }

        return $this->saveUniversidadPort->save($universidad);
    }
}
