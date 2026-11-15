<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateDocenteUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveDocentePort.php';
require_once __DIR__ . '/../Ports/Out/GetDocenteByEmailPort.php';
require_once __DIR__ . '/Mappers/DocenteApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/DocenteAlreadyExistsException.php';

/**
 * Caso de uso: registrar un docente.
 * 1. Construye el modelo (los Value Objects validan cada dato).
 * 2. Verifica que el email no esté registrado.
 * 3. Guarda usando el puerto de salida.
 */
final class CreateDocenteService implements CreateDocenteUseCase
{
    private SaveDocentePort $saveDocentePort;
    private GetDocenteByEmailPort $getDocenteByEmailPort;

    public function __construct(
        SaveDocentePort $saveDocentePort,
        GetDocenteByEmailPort $getDocenteByEmailPort
    ) {
        $this->saveDocentePort = $saveDocentePort;
        $this->getDocenteByEmailPort = $getDocenteByEmailPort;
    }

    public function execute(CreateDocenteCommand $command): DocenteModel
    {
        $docente = DocenteApplicationMapper::fromCreateCommandToModel($command);

        if ($this->getDocenteByEmailPort->getByEmail($docente->email()) !== null) {
            throw DocenteAlreadyExistsException::becauseEmailAlreadyExists($docente->email()->value());
        }

        return $this->saveDocentePort->save($docente);
    }
}
