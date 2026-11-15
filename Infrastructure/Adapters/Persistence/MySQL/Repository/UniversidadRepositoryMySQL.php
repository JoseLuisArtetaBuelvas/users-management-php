<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveUniversidadPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateUniversidadPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetUniversidadByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetUniversidadByNombrePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetUniversidadByEmailPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllUniversidadesPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteUniversidadPort.php';
require_once __DIR__ . '/../Mapper/UniversidadPersistenceMapper.php';

/**
 * Adaptador de salida: implementa los puertos de persistencia de Universidad
 * con PDO y sentencias preparadas. El SQL es compatible con MySQL/MariaDB
 * (local) y PostgreSQL (Supabase); el motor lo elige DB_DRIVER.
 */
final class UniversidadRepositoryMySQL implements
    SaveUniversidadPort,
    UpdateUniversidadPort,
    GetUniversidadByIdPort,
    GetUniversidadByNombrePort,
    GetUniversidadByEmailPort,
    GetAllUniversidadesPort,
    DeleteUniversidadPort
{
    private const COLUMNS = '
        id, nombre, categoria, web, rector, email, acceso, telefono, ciudad,
        numero_carreras, num_sedes, created_at, updated_at
    ';

    public function __construct(
        private PDO $pdo,
        private UniversidadPersistenceMapper $mapper
    ) {
    }

    public function save(UniversidadModel $universidad): UniversidadModel
    {
        $sql = '
            INSERT INTO universidades (
                id, nombre, categoria, web, rector, email, acceso, telefono, ciudad,
                numero_carreras, num_sedes, created_at, updated_at
            ) VALUES (
                :id, :nombre, :categoria, :web, :rector, :email, :acceso, :telefono, :ciudad,
                :numero_carreras, :num_sedes, NOW(), NOW()
            )
        ';

        $this->pdo->prepare($sql)->execute($this->toParameters($this->mapper->fromModelToDto($universidad)));

        return $this->findOrFail($universidad->id(), 'save');
    }

    public function update(UniversidadModel $universidad): UniversidadModel
    {
        $sql = '
            UPDATE universidades
               SET nombre = :nombre,
                   categoria = :categoria,
                   web = :web,
                   rector = :rector,
                   email = :email,
                   acceso = :acceso,
                   telefono = :telefono,
                   ciudad = :ciudad,
                   numero_carreras = :numero_carreras,
                   num_sedes = :num_sedes,
                   updated_at = NOW()
             WHERE id = :id
        ';

        $this->pdo->prepare($sql)->execute($this->toParameters($this->mapper->fromModelToDto($universidad)));

        return $this->findOrFail($universidad->id(), 'update');
    }

    public function getById(UniversidadId $universidadId): ?UniversidadModel
    {
        return $this->fetchOne('id = :value', $universidadId->value());
    }

    public function getByNombre(UniversidadNombre $nombre): ?UniversidadModel
    {
        // Comparación sin distinguir mayúsculas en ambos motores
        return $this->fetchOne('LOWER(nombre) = :value', mb_strtolower($nombre->value()));
    }

    public function getByEmail(UniversidadEmail $email): ?UniversidadModel
    {
        return $this->fetchOne('email = :value', $email->value());
    }

    /**
     * @return UniversidadModel[]
     */
    public function getAll(?string $search = null): array
    {
        $sql = 'SELECT ' . self::COLUMNS . ' FROM universidades';
        $parameters = array();

        if ($search !== null && $search !== '') {
            $sql .= '
                WHERE LOWER(nombre) LIKE :s1
                   OR LOWER(ciudad) LIKE :s2
                   OR LOWER(rector) LIKE :s3
                   OR LOWER(email) LIKE :s4
            ';
            $like = '%' . mb_strtolower($search) . '%';
            $parameters = array(':s1' => $like, ':s2' => $like, ':s3' => $like, ':s4' => $like);
        }

        $statement = $this->pdo->prepare($sql . ' ORDER BY nombre ASC');
        $statement->execute($parameters);

        return $this->mapper->fromRowsToModels($statement->fetchAll());
    }

    public function delete(UniversidadId $universidadId): void
    {
        $this->pdo->prepare('DELETE FROM universidades WHERE id = :id')
            ->execute(array(':id' => $universidadId->value()));
    }

    private function fetchOne(string $condition, string $value): ?UniversidadModel
    {
        $statement = $this->pdo->prepare(
            'SELECT ' . self::COLUMNS . ' FROM universidades WHERE ' . $condition . ' LIMIT 1'
        );
        $statement->execute(array(':value' => $value));
        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    /**
     * @return array<string, string|int>
     */
    private function toParameters(UniversidadPersistenceDto $dto): array
    {
        return array(
            ':id' => $dto->id(),
            ':nombre' => $dto->nombre(),
            ':categoria' => $dto->categoria(),
            ':web' => $dto->web(),
            ':rector' => $dto->rector(),
            ':email' => $dto->email(),
            ':acceso' => $dto->acceso(),
            ':telefono' => $dto->telefono(),
            ':ciudad' => $dto->ciudad(),
            ':numero_carreras' => $dto->numeroCarreras(),
            ':num_sedes' => $dto->numSedes(),
        );
    }

    private function findOrFail(UniversidadId $universidadId, string $operation): UniversidadModel
    {
        $universidad = $this->getById($universidadId);

        if ($universidad === null) {
            throw new RuntimeException('La universidad no pudo recuperarse después de ' . $operation . '.');
        }

        return $universidad;
    }
}
