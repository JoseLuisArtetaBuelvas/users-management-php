<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllDocentesUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllDocentesPort.php';

final class GetAllDocentesService implements GetAllDocentesUseCase
{
    private GetAllDocentesPort $getAllDocentesPort;

    public function __construct(GetAllDocentesPort $getAllDocentesPort)
    {
        $this->getAllDocentesPort = $getAllDocentesPort;
    }

    /**
     * @return DocenteModel[]
     */
    public function execute(GetAllDocentesQuery $query): array
    {
        return $this->getAllDocentesPort->getAll($query->getSearch());
    }
}
