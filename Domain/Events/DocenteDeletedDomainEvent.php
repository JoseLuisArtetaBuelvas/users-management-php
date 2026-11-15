<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../ValueObjects/DocenteId.php';

final class DocenteDeletedDomainEvent extends DomainEvent
{
    private DocenteId $docenteId;

    public function __construct(DocenteId $docenteId)
    {
        parent::__construct('docente.deleted');
        $this->docenteId = $docenteId;
    }

    public function docenteId(): DocenteId
    {
        return $this->docenteId;
    }

    /**
     * @return array<string, string>
     */
    public function payload(): array
    {
        return array('id' => $this->docenteId->value());
    }
}
