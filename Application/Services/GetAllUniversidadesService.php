<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllUniversidadesUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllUniversidadesPort.php';

final class GetAllUniversidadesService implements GetAllUniversidadesUseCase
{
    public function __construct(private GetAllUniversidadesPort $getAllUniversidadesPort)
    {
    }

    /**
     * @return UniversidadModel[]
     */
    public function execute(GetAllUniversidadesQuery $query): array
    {
        return $this->getAllUniversidadesPort->getAll($query->getSearch());
    }
}
