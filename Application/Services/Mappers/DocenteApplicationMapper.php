<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateDocenteCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateDocenteCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteDocenteCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetDocenteByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/DocenteModel.php';

/**
 * Traduce los DTO de aplicación (commands / queries) a objetos del dominio.
 * No contiene reglas de negocio: las validaciones viven en los Value Objects.
 */
final class DocenteApplicationMapper
{
    public static function fromCreateCommandToModel(CreateDocenteCommand $command): DocenteModel
    {
        return new DocenteModel(
            new DocenteId($command->getId()),
            new DocenteNombre($command->getNombre()),
            DocenteNombre::apellidos($command->getApellidos()),
            new DocenteEmail($command->getEmail()),
            new DocenteTelefono($command->getTelefono()),
            new DocenteBlog($command->getBlog()),
            DocenteCampoTexto::profesional($command->getProfesional()),
            $command->getEscalafon(),
            $command->getIdioma(),
            DocenteAniosExperiencia::fromString($command->getAniosExperiencia()),
            DocenteCampoTexto::areaTrabajo($command->getAreaTrabajo())
        );
    }

    public static function fromUpdateCommandToModel(UpdateDocenteCommand $command): DocenteModel
    {
        return new DocenteModel(
            new DocenteId($command->getId()),
            new DocenteNombre($command->getNombre()),
            DocenteNombre::apellidos($command->getApellidos()),
            new DocenteEmail($command->getEmail()),
            new DocenteTelefono($command->getTelefono()),
            new DocenteBlog($command->getBlog()),
            DocenteCampoTexto::profesional($command->getProfesional()),
            $command->getEscalafon(),
            $command->getIdioma(),
            DocenteAniosExperiencia::fromString($command->getAniosExperiencia()),
            DocenteCampoTexto::areaTrabajo($command->getAreaTrabajo())
        );
    }

    public static function fromGetByIdQueryToDocenteId(GetDocenteByIdQuery $query): DocenteId
    {
        return new DocenteId($query->getId());
    }

    public static function fromDeleteCommandToDocenteId(DeleteDocenteCommand $command): DocenteId
    {
        return new DocenteId($command->getId());
    }

    /**
     * @return array<string, string|int>
     */
    public static function fromModelToArray(DocenteModel $docente): array
    {
        return $docente->toArray();
    }

    /**
     * @param DocenteModel[] $docentes
     * @return array<int, array<string, string|int>>
     */
    public static function fromModelsToArray(array $docentes): array
    {
        $result = array();

        foreach ($docentes as $docente) {
            $result[] = self::fromModelToArray($docente);
        }

        return $result;
    }
}
