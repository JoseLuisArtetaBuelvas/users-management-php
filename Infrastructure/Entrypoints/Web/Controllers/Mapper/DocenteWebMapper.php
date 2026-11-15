<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateDocenteRequest.php';
require_once __DIR__ . '/../Dto/UpdateDocenteRequest.php';
require_once __DIR__ . '/../Dto/DocenteResponse.php';

require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateDocenteCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateDocenteCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteDocenteCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetDocenteByIdQuery.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetAllDocentesQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/DocenteModel.php';

/**
 * Traduce entre la capa web (requests / responses) y la capa de aplicación
 * (commands / queries / modelos).
 */
final class DocenteWebMapper
{
    public function fromCreateRequestToCommand(CreateDocenteWebRequest $request): CreateDocenteCommand
    {
        return new CreateDocenteCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getApellidos(),
            $request->getEmail(),
            $request->getTelefono(),
            $request->getBlog(),
            $request->getProfesional(),
            $request->getEscalafon(),
            $request->getIdioma(),
            $request->getAniosExperiencia(),
            $request->getAreaTrabajo()
        );
    }

    public function fromUpdateRequestToCommand(UpdateDocenteWebRequest $request): UpdateDocenteCommand
    {
        return new UpdateDocenteCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getApellidos(),
            $request->getEmail(),
            $request->getTelefono(),
            $request->getBlog(),
            $request->getProfesional(),
            $request->getEscalafon(),
            $request->getIdioma(),
            $request->getAniosExperiencia(),
            $request->getAreaTrabajo()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetDocenteByIdQuery
    {
        return new GetDocenteByIdQuery($id);
    }

    public function fromSearchToGetAllQuery(?string $search): GetAllDocentesQuery
    {
        return new GetAllDocentesQuery($search);
    }

    public function fromIdToDeleteCommand(string $id): DeleteDocenteCommand
    {
        return new DeleteDocenteCommand($id);
    }

    public function fromModelToResponse(DocenteModel $docente): DocenteResponse
    {
        return new DocenteResponse(
            $docente->id()->value(),
            $docente->nombre()->value(),
            $docente->apellidos()->value(),
            $docente->email()->value(),
            $docente->telefono()->value(),
            $docente->blog()->value(),
            $docente->profesional()->value(),
            $docente->escalafon(),
            $docente->idioma(),
            $docente->aniosExperiencia()->value(),
            $docente->areaTrabajo()->value(),
            $docente->esExperimentado()
        );
    }

    /**
     * @param DocenteModel[] $docentes
     * @return DocenteResponse[]
     */
    public function fromModelsToResponses(array $docentes): array
    {
        return array_map(fn(DocenteModel $docente) => $this->fromModelToResponse($docente), $docentes);
    }
}
