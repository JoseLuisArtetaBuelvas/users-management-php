<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/DocentePersistenceDto.php';
require_once __DIR__ . '/../Entity/DocenteEntity.php';
require_once __DIR__ . '/../../../../../Domain/Models/DocenteModel.php';

/**
 * Convierte entre el modelo de dominio y las estructuras de persistencia:
 * Model -> Dto (para escribir) y fila SQL -> Entity -> Model (para leer).
 */
final class DocentePersistenceMapper
{
    public function fromModelToDto(DocenteModel $docente): DocentePersistenceDto
    {
        return new DocentePersistenceDto(
            $docente->id()->value(),
            $docente->nombre()->value(),
            $docente->apellidos()->value(),
            $docente->email()->value(),
            $docente->telefono()->value(),
            $docente->blog()->isEmpty() ? null : $docente->blog()->value(),
            $docente->profesional()->value(),
            $docente->escalafon(),
            $docente->idioma(),
            $docente->aniosExperiencia()->value(),
            $docente->areaTrabajo()->value()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToEntity(array $row): DocenteEntity
    {
        return new DocenteEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (string) $row['apellidos'],
            (string) $row['email'],
            (string) $row['telefono'],
            isset($row['blog']) ? (string) $row['blog'] : null,
            (string) $row['profesional'],
            (string) $row['escalafon'],
            (string) $row['idioma'],
            (int) $row['anios_experiencia'],
            (string) $row['area_trabajo'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(DocenteEntity $entity): DocenteModel
    {
        return new DocenteModel(
            new DocenteId($entity->id()),
            new DocenteNombre($entity->nombre()),
            DocenteNombre::apellidos($entity->apellidos()),
            new DocenteEmail($entity->email()),
            new DocenteTelefono($entity->telefono()),
            new DocenteBlog($entity->blog() ?? ''),
            DocenteCampoTexto::profesional($entity->profesional()),
            $entity->escalafon(),
            $entity->idioma(),
            new DocenteAniosExperiencia($entity->aniosExperiencia()),
            DocenteCampoTexto::areaTrabajo($entity->areaTrabajo())
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToModel(array $row): DocenteModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return DocenteModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        return array_map(fn(array $row) => $this->fromRowToModel($row), $rows);
    }
}
