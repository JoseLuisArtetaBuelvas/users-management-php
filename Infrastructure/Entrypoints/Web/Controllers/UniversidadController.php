<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/UniversidadWebMapper.php';

require_once __DIR__ . '/../../../../Application/Ports/In/CreateUniversidadUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateUniversidadUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetUniversidadByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllUniversidadesUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteUniversidadUseCase.php';

/**
 * Adaptador de entrada (entrypoint web) del CRUDL de Universidad.
 * Flujo: Request -> Mapper -> Command/Query -> UseCase -> Modelo -> Response.
 */
final class UniversidadController
{
    public function __construct(
        private CreateUniversidadUseCase $createUniversidadUseCase,
        private UpdateUniversidadUseCase $updateUniversidadUseCase,
        private GetUniversidadByIdUseCase $getUniversidadByIdUseCase,
        private GetAllUniversidadesUseCase $getAllUniversidadesUseCase,
        private DeleteUniversidadUseCase $deleteUniversidadUseCase,
        private UniversidadWebMapper $mapper
    ) {
    }

    /**
     * @return UniversidadResponse[]
     */
    public function index(?string $search = null): array
    {
        $universidades = $this->getAllUniversidadesUseCase->execute($this->mapper->fromSearchToGetAllQuery($search));

        return $this->mapper->fromModelsToResponses($universidades);
    }

    public function show(string $id): UniversidadResponse
    {
        $universidad = $this->getUniversidadByIdUseCase->execute($this->mapper->fromIdToGetByIdQuery($id));

        return $this->mapper->fromModelToResponse($universidad);
    }

    public function store(CreateUniversidadWebRequest $request): UniversidadResponse
    {
        $universidad = $this->createUniversidadUseCase->execute($this->mapper->fromCreateRequestToCommand($request));

        return $this->mapper->fromModelToResponse($universidad);
    }

    public function update(UpdateUniversidadWebRequest $request): UniversidadResponse
    {
        $universidad = $this->updateUniversidadUseCase->execute($this->mapper->fromUpdateRequestToCommand($request));

        return $this->mapper->fromModelToResponse($universidad);
    }

    public function delete(string $id): void
    {
        $this->deleteUniversidadUseCase->execute($this->mapper->fromIdToDeleteCommand($id));
    }
}
