<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateUniversidadCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateUniversidadCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteUniversidadCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetUniversidadByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/UniversidadModel.php';

/**
 * Traduce los DTO de aplicación (commands / queries) a objetos del dominio.
 * No contiene reglas de negocio: las validaciones viven en los Value Objects.
 */
final class UniversidadApplicationMapper
{
    public static function fromCreateCommandToModel(CreateUniversidadCommand $command): UniversidadModel
    {
        return self::buildModel(
            $command->getId(), $command->getNombre(), $command->getCategoria(), $command->getWeb(),
            $command->getRector(), $command->getEmail(), $command->getAcceso(), $command->getTelefono(),
            $command->getCiudad(), $command->getNumeroCarreras(), $command->getNumSedes()
        );
    }

    public static function fromUpdateCommandToModel(UpdateUniversidadCommand $command): UniversidadModel
    {
        return self::buildModel(
            $command->getId(), $command->getNombre(), $command->getCategoria(), $command->getWeb(),
            $command->getRector(), $command->getEmail(), $command->getAcceso(), $command->getTelefono(),
            $command->getCiudad(), $command->getNumeroCarreras(), $command->getNumSedes()
        );
    }

    public static function fromGetByIdQueryToUniversidadId(GetUniversidadByIdQuery $query): UniversidadId
    {
        return new UniversidadId($query->getId());
    }

    public static function fromDeleteCommandToUniversidadId(DeleteUniversidadCommand $command): UniversidadId
    {
        return new UniversidadId($command->getId());
    }

    /**
     * @return array<string, string|int>
     */
    public static function fromModelToArray(UniversidadModel $universidad): array
    {
        return $universidad->toArray();
    }

    /**
     * @param UniversidadModel[] $universidades
     * @return array<int, array<string, string|int>>
     */
    public static function fromModelsToArray(array $universidades): array
    {
        return array_map(fn(UniversidadModel $u) => self::fromModelToArray($u), $universidades);
    }

    private static function buildModel(
        string $id,
        string $nombre,
        string $categoria,
        string $web,
        string $rector,
        string $email,
        string $acceso,
        string $telefono,
        string $ciudad,
        string $numeroCarreras,
        string $numSedes
    ): UniversidadModel {
        return new UniversidadModel(
            new UniversidadId($id),
            new UniversidadNombre($nombre),
            $categoria,
            new UniversidadWeb($web),
            UniversidadNombrePropio::rector($rector),
            new UniversidadEmail($email),
            $acceso,
            new UniversidadTelefono($telefono),
            UniversidadNombrePropio::ciudad($ciudad),
            UniversidadCantidad::numeroCarrerasFromString($numeroCarreras),
            UniversidadCantidad::numSedesFromString($numSedes)
        );
    }
}
