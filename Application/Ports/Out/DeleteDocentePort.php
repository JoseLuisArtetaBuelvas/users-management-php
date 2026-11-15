<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/DocenteId.php';

interface DeleteDocentePort
{
    public function delete(DocenteId $docenteId): void;
}
