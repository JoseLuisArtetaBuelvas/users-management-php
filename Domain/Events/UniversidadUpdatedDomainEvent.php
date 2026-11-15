<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/UniversidadModel.php';

final class UniversidadUpdatedDomainEvent extends DomainEvent
{
    private UniversidadModel $universidad;

    public function __construct(UniversidadModel $universidad)
    {
        parent::__construct('universidad.updated');
        $this->universidad = $universidad;
    }

    public function universidad(): UniversidadModel
    {
        return $this->universidad;
    }

    /**
     * @return array<string, string|int>
     */
    public function payload(): array
    {
        return $this->universidad->toArray();
    }
}