<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveDocentePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateDocentePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetDocenteByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetDocenteByEmailPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllDocentesPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteDocentePort.php';
require_once __DIR__ . '/../Mapper/DocentePersistenceMapper.php';

/**
 * Adaptador de salida: implementa los puertos de persistencia de Docente
 * sobre MySQL/MariaDB usando PDO con sentencias preparadas.
 */
final class DocenteRepositoryMySQL implements
    SaveDocentePort,
    UpdateDocentePort,
    GetDocenteByIdPort,
    GetDocenteByEmailPort,
    GetAllDocentesPort,
    DeleteDocentePort
{
    private const COLUMNS = '
        id, nombre, apellidos, email, telefono, blog, profesional,
        escalafon, idioma, anios_experiencia, area_trabajo, created_at, updated_at
    ';

    private PDO $pdo;
    private DocentePersistenceMapper $mapper;

    public function __construct(PDO $pdo, DocentePersistenceMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(DocenteModel $docente): DocenteModel
    {
        $dto = $this->mapper->fromModelToDto($docente);

        $sql = '
            INSERT INTO docentes (
                id, nombre, apellidos, email, telefono, blog, profesional,
                escalafon, idioma, anios_experiencia, area_trabajo, created_at, updated_at
            ) VALUES (
                :id, :nombre, :apellidos, :email, :telefono, :blog, :profesional,
                :escalafon, :idioma, :anios_experiencia, :area_trabajo, NOW(), NOW()
            )
        ';

        $this->pdo->prepare($sql)->execute($this->toParameters($dto));

        return $this->findOrFail($docente->id(), 'save');
    }

    public function update(DocenteModel $docente): DocenteModel
    {
        $dto = $this->mapper->fromModelToDto($docente);

        $sql = '
            UPDATE docentes
               SET nombre = :nombre,
                   apellidos = :apellidos,
                   email = :email,
                   telefono = :telefono,
                   blog = :blog,
                   profesional = :profesional,
                   escalafon = :escalafon,
                   idioma = :idioma,
                   anios_experiencia = :anios_experiencia,
                   area_trabajo = :area_trabajo,
                   updated_at = NOW()
             WHERE id = :id
        ';

        $this->pdo->prepare($sql)->execute($this->toParameters($dto));

        return $this->findOrFail($docente->id(), 'update');
    }

    public function getById(DocenteId $docenteId): ?DocenteModel
    {
        $statement = $this->pdo->prepare('SELECT ' . self::COLUMNS . ' FROM docentes WHERE id = :id LIMIT 1');
        $statement->execute(array(':id' => $docenteId->value()));
        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    public function getByEmail(DocenteEmail $email): ?DocenteModel
    {
        $statement = $this->pdo->prepare('SELECT ' . self::COLUMNS . ' FROM docentes WHERE email = :email LIMIT 1');
        $statement->execute(array(':email' => $email->value()));
        $row = $statement->fetch();

        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    /**
     * @return DocenteModel[]
     */
    public function getAll(?string $search = null): array
    {
        $sql = 'SELECT ' . self::COLUMNS . ' FROM docentes';
        $parameters = array();

        if ($search !== null && $search !== '') {
            // LOWER en ambos lados: búsqueda sin distinguir mayúsculas
            // tanto en MySQL como en PostgreSQL (donde LIKE sí distingue).
            $sql .= '
                WHERE LOWER(nombre) LIKE :s1
                   OR LOWER(apellidos) LIKE :s2
                   OR LOWER(email) LIKE :s3
                   OR LOWER(area_trabajo) LIKE :s4
            ';
            $like = '%' . mb_strtolower($search) . '%';
            $parameters = array(':s1' => $like, ':s2' => $like, ':s3' => $like, ':s4' => $like);
        }

        $sql .= ' ORDER BY apellidos ASC, nombre ASC';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($parameters);

        return $this->mapper->fromRowsToModels($statement->fetchAll());
    }

    public function delete(DocenteId $docenteId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM docentes WHERE id = :id');
        $statement->execute(array(':id' => $docenteId->value()));
    }

    /**
     * @return array<string, string|int|null>
     */
    private function toParameters(DocentePersistenceDto $dto): array
    {
        return array(
            ':id' => $dto->id(),
            ':nombre' => $dto->nombre(),
            ':apellidos' => $dto->apellidos(),
            ':email' => $dto->email(),
            ':telefono' => $dto->telefono(),
            ':blog' => $dto->blog(),
            ':profesional' => $dto->profesional(),
            ':escalafon' => $dto->escalafon(),
            ':idioma' => $dto->idioma(),
            ':anios_experiencia' => $dto->aniosExperiencia(),
            ':area_trabajo' => $dto->areaTrabajo(),
        );
    }

    private function findOrFail(DocenteId $docenteId, string $operation): DocenteModel
    {
        $docente = $this->getById($docenteId);

        if ($docente === null) {
            throw new RuntimeException('El docente no pudo recuperarse después de ' . $operation . '.');
        }

        return $docente;
    }
}
