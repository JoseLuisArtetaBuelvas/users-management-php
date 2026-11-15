<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateUniversidadRequest.php';
require_once __DIR__ . '/../Dto/UpdateUniversidadRequest.php';
require_once __DIR__ . '/../Dto/UniversidadResponse.php';

require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateUniversidadCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateUniversidadCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteUniversidadCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetUniversidadByIdQuery.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetAllUniversidadesQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/UniversidadModel.php';

/**
 * Traduce entre la capa web (requests / responses) y la capa de aplicación
 * (commands / queries / modelos).
 */
final class UniversidadWebMapper
{
    public function fromCreateRequestToCommand(CreateUniversidadWebRequest $r): CreateUniversidadCommand
    {
        return new CreateUniversidadCommand(
            $r->getId(), $r->getNombre(), $r->getCategoria(), $r->getWeb(), $r->getRector(), $r->getEmail(),
            $r->getAcceso(), $r->getTelefono(), $r->getCiudad(), $r->getNumeroCarreras(), $r->getNumSedes()
        );
    }

    public function fromUpdateRequestToCommand(UpdateUniversidadWebRequest $r): UpdateUniversidadCommand
    {
        return new UpdateUniversidadCommand(
            $r->getId(), $r->getNombre(), $r->getCategoria(), $r->getWeb(), $r->getRector(), $r->getEmail(),
            $r->getAcceso(), $r->getTelefono(), $r->getCiudad(), $r->getNumeroCarreras(), $r->getNumSedes()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetUniversidadByIdQuery
    {
        return new GetUniversidadByIdQuery($id);
    }

    public function fromSearchToGetAllQuery(?string $search): GetAllUniversidadesQuery
    {
        return new GetAllUniversidadesQuery($search);
    }

    public function fromIdToDeleteCommand(string $id): DeleteUniversidadCommand
    {
        return new DeleteUniversidadCommand($id);
    }

    public function fromModelToResponse(UniversidadModel $u): UniversidadResponse
    {
        return new UniversidadResponse(
            $u->id()->value(),
            $u->nombre()->value(),
            $u->categoria(),
            UniversidadCategoriaEnum::label($u->categoria()),
            $u->web()->value(),
            $u->rector()->value(),
            $u->email()->value(),
            $u->acceso(),
            UniversidadAccesoEnum::label($u->acceso()),
            $u->telefono()->value(),
            $u->ciudad()->value(),
            $u->numeroCarreras()->value(),
            $u->numSedes()->value(),
            $u->esMultisede(),
            $u->carrerasPorSede()
        );
    }

    /**
     * @param UniversidadModel[] $universidades
     * @return UniversidadResponse[]
     */
    public function fromModelsToResponses(array $universidades): array
    {
        return array_map(fn(UniversidadModel $u) => $this->fromModelToResponse($u), $universidades);
    }
}
