<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../ValueObjects/UniversidadId.php';

final class UniversidadDeletedDomainEvent extends DomainEvent
{
    private UniversidadId $universidadId;

    public function __construct(UniversidadId $universidadId)
    {
        parent::__construct('universidad.deleted');
        $this->universidadId = $universidadId;
    }

    public function universidadId(): UniversidadId
    {
        return $this->universidadId;
    }

    /**
     * @return array<string, string>
     */
    public function payload(): array
    {
        return array('id' => $this->universidadId->value());
    }
}
