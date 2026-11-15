<?php

declare(strict_types=1);

/**
 * Consulta (CQRS) para listar universidades, con filtro de búsqueda opcional
 * por nombre, ciudad, rector o email.
 */
final class GetAllUniversidadesQuery
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
