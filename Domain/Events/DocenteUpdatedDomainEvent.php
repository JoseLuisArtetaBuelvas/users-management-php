<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomain.php';
require_once __DIR__ . '/../Models/DocenteModel.php';

final class DocenteUpdatedDomainEvent extends DomainEvent
{
    private DocenteModel $docente;

    public function __construct(DocenteModel $docente)
    {
        parent::__construct('docente.updated');
        $this->docente = $docente;
    }

    public function docente(): DocenteModel
    {
        return $this->docente;
    }

    /**
     * @return array<string, string|int>
     */
    public function payload(): array
    {
        return $this->docente->toArray();
    }
}
