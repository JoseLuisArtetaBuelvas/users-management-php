<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/UniversidadPersistenceDto.php';
require_once __DIR__ . '/../Entity/UniversidadEntity.php';
require_once __DIR__ . '/../../../../../Domain/Models/UniversidadModel.php';

/**
 * Convierte entre el modelo de dominio y las estructuras de persistencia:
 * Model -> Dto (para escribir) y fila SQL -> Entity -> Model (para leer).
 */
final class UniversidadPersistenceMapper
{
    public function fromModelToDto(UniversidadModel $u): UniversidadPersistenceDto
    {
        return new UniversidadPersistenceDto(
            $u->id()->value(),
            $u->nombre()->value(),
            $u->categoria(),
            $u->web()->value(),
            $u->rector()->value(),
            $u->email()->value(),
            $u->acceso(),
            $u->telefono()->value(),
            $u->ciudad()->value(),
            $u->numeroCarreras()->value(),
            $u->numSedes()->value()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToEntity(array $row): UniversidadEntity
    {
        return new UniversidadEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (string) $row['categoria'],
            (string) $row['web'],
            (string) $row['rector'],
            (string) $row['email'],
            (string) $row['acceso'],
            (string) $row['telefono'],
            (string) $row['ciudad'],
            (int) $row['numero_carreras'],
            (int) $row['num_sedes'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(UniversidadEntity $e): UniversidadModel
    {
        return new UniversidadModel(
            new UniversidadId($e->id()),
            new UniversidadNombre($e->nombre()),
            $e->categoria(),
            new UniversidadWeb($e->web()),
            UniversidadNombrePropio::rector($e->rector()),
            new UniversidadEmail($e->email()),
            $e->acceso(),
            new UniversidadTelefono($e->telefono()),
            UniversidadNombrePropio::ciudad($e->ciudad()),
            UniversidadCantidad::numeroCarreras($e->numeroCarreras()),
            UniversidadCantidad::numSedes($e->numSedes())
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToModel(array $row): UniversidadModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return UniversidadModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        return array_map(fn(array $row) => $this->fromRowToModel($row), $rows);
    }
}
