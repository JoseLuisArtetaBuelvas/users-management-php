<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/DocenteWebMapper.php';

require_once __DIR__ . '/../../../../Application/Ports/In/CreateDocenteUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateDocenteUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetDocenteByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllDocentesUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteDocenteUseCase.php';

/**
 * Adaptador de entrada (entrypoint web) del CRUDL de Docente.
 * Flujo: Request -> Mapper -> Command/Query -> UseCase -> Modelo -> Response.
 */
final class DocenteController
{
    public function __construct(
        private CreateDocenteUseCase $createDocenteUseCase,
        private UpdateDocenteUseCase $updateDocenteUseCase,
        private GetDocenteByIdUseCase $getDocenteByIdUseCase,
        private GetAllDocentesUseCase $getAllDocentesUseCase,
        private DeleteDocenteUseCase $deleteDocenteUseCase,
        private DocenteWebMapper $mapper
    ) {
    }

    /**
     * @return DocenteResponse[]
     */
    public function index(?string $search = null): array
    {
        $docentes = $this->getAllDocentesUseCase->execute($this->mapper->fromSearchToGetAllQuery($search));

        return $this->mapper->fromModelsToResponses($docentes);
    }

    public function show(string $id): DocenteResponse
    {
        $docente = $this->getDocenteByIdUseCase->execute($this->mapper->fromIdToGetByIdQuery($id));

        return $this->mapper->fromModelToResponse($docente);
    }

    public function store(CreateDocenteWebRequest $request): DocenteResponse
    {
        $docente = $this->createDocenteUseCase->execute($this->mapper->fromCreateRequestToCommand($request));

        return $this->mapper->fromModelToResponse($docente);
    }

    public function update(UpdateDocenteWebRequest $request): DocenteResponse
    {
        $docente = $this->updateDocenteUseCase->execute($this->mapper->fromUpdateRequestToCommand($request));

        return $this->mapper->fromModelToResponse($docente);
    }

    public function delete(string $id): void
    {
        $this->deleteDocenteUseCase->execute($this->mapper->fromIdToDeleteCommand($id));
    }
}
