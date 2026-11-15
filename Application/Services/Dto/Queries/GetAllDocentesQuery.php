<?php

declare(strict_types=1);

/**
 * Consulta (CQRS) para listar docentes, con filtro de búsqueda opcional
 * por nombre, apellidos, email o área de trabajo.
 */
final class GetAllDocentesQuery
{
    private ?string $search;

    public function __construct(?string $search = null)
    {
        $normalized = $search !== null ? trim($search) : '';
        $this->search = $normalized !== '' ? $normalized : null;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }
}
