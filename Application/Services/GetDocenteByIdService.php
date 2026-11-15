<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetDocenteByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetDocenteByIdPort.php';
require_once __DIR__ . '/Mappers/DocenteApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/DocenteNotFoundException.php';

final class GetDocenteByIdService implements GetDocenteByIdUseCase
{
    private GetDocenteByIdPort $getDocenteByIdPort;

    public function __construct(GetDocenteByIdPort $getDocenteByIdPort)
    {
        $this->getDocenteByIdPort = $getDocenteByIdPort;
    }

    public function execute(GetDocenteByIdQuery $query): DocenteModel
    {
        $docenteId = DocenteApplicationMapper::fromGetByIdQueryToDocenteId($query);
        $docente = $this->getDocenteByIdPort->getById($docenteId);

        if ($docente === null) {
            throw DocenteNotFoundException::becauseIdWasNotFound($docenteId->value());
        }

        return $docente;
    }
}
