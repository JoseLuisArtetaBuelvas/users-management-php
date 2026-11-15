<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetUniversidadByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetUniversidadByIdPort.php';
require_once __DIR__ . '/Mappers/UniversidadApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/UniversidadNotFoundException.php';

final class GetUniversidadByIdService implements GetUniversidadByIdUseCase
{
    public function __construct(private GetUniversidadByIdPort $getUniversidadByIdPort)
    {
    }

    public function execute(GetUniversidadByIdQuery $query): UniversidadModel
    {
        $id = UniversidadApplicationMapper::fromGetByIdQueryToUniversidadId($query);
        $universidad = $this->getUniversidadByIdPort->getById($id);

        if ($universidad === null) {
            throw UniversidadNotFoundException::becauseIdWasNotFound($id->value());
        }

        return $universidad;
    }
}
