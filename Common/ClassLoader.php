<?php

declare(strict_types=1);

final class ClassLoader
{
    /**
     * @var array<string, string>
     */
    private static array $classMap = array(
        'InvalidUserEmailException' => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException' => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException' => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException' => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException' => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException' => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException' => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException' => 'Domain/Exceptions/InvalidCredentialsException.php',

        'UserRoleEnum' => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum' => 'Domain/Enums/UserStatusEnum.php',

        'UserId' => 'Domain/ValueObjects/UserId.php',
        'UserName' => 'Domain/ValueObjects/UserName.php',
        'UserEmail' => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword' => 'Domain/ValueObjects/UserPassword.php',

        'UserModel' => 'Domain/Models/UserModel.php',
        'EmailDestinationModel' => 'Domain/Models/EmailDestinationModel.php',
        'EmailSenderException' => 'Domain/Exceptions/EmailSenderException.php',
        'EmailSenderPort' => 'Application/Ports/Out/EmailSenderPort.php',
        'EmailNotificationService' => 'Application/Services/EmailNotificationService.php',
        'EmailSenderService' => 'Infrastructure/Adapters/Email/EmailSenderService.php',

        'CreateUserUseCase' => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase' => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase' => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase' => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase' => 'Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase' => 'Application/Ports/In/LoginUseCase.php',

        'SaveUserPort' => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort' => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort' => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort' => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort' => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort' => 'Application/Ports/Out/DeleteUserPort.php',

        'CreateUserCommand' => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand' => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand' => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand' => 'Application/Services/Dto/Commands/LoginCommand.php',
        'GetUserByIdQuery' => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery' => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',

        'CreateUserService' => 'Application/Services/CreateUserService.php',
        'UpdateUserService' => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService' => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService' => 'Application/Services/GetAllUsersService.php',
        'DeleteUserService' => 'Application/Services/DeleteUserService.php',
        'LoginService' => 'Application/Services/LoginService.php',
        'UserApplicationMapper' => 'Application/Services/Mappers/UserApplicationMapper.php',

        'Connection' => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',

        'CreateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController' => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'WebRoutes' => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',

        'View' => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash' => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',

        'DependencyInjection' => 'Common/DependencyInjection.php',

        // ── Universidad (ejercicio 2) ─────────────────────────────
        'InvalidUniversidadIdException' => 'Domain/Exceptions/InvalidUniversidadIdException.php',
        'InvalidUniversidadNombreException' => 'Domain/Exceptions/InvalidUniversidadNombreException.php',
        'InvalidUniversidadPersonaException' => 'Domain/Exceptions/InvalidUniversidadPersonaException.php',
        'InvalidUniversidadWebException' => 'Domain/Exceptions/InvalidUniversidadWebException.php',
        'InvalidUniversidadEmailException' => 'Domain/Exceptions/InvalidUniversidadEmailException.php',
        'InvalidUniversidadTelefonoException' => 'Domain/Exceptions/InvalidUniversidadTelefonoException.php',
        'InvalidUniversidadCantidadException' => 'Domain/Exceptions/InvalidUniversidadCantidadException.php',
        'InvalidUniversidadCategoriaException' => 'Domain/Exceptions/InvalidUniversidadCategoriaException.php',
        'InvalidUniversidadAccesoException' => 'Domain/Exceptions/InvalidUniversidadAccesoException.php',
        'UniversidadAlreadyExistsException' => 'Domain/Exceptions/UniversidadAlreadyExistsException.php',
        'UniversidadNotFoundException' => 'Domain/Exceptions/UniversidadNotFoundException.php',

        'UniversidadCategoriaEnum' => 'Domain/Enums/UniversidadCategoriaEnum.php',
        'UniversidadAccesoEnum' => 'Domain/Enums/UniversidadAccesoEnum.php',

        'UniversidadId' => 'Domain/ValueObjects/UniversidadId.php',
        'UniversidadNombre' => 'Domain/ValueObjects/UniversidadNombre.php',
        'UniversidadNombrePropio' => 'Domain/ValueObjects/UniversidadNombrePropio.php',
        'UniversidadWeb' => 'Domain/ValueObjects/UniversidadWeb.php',
        'UniversidadEmail' => 'Domain/ValueObjects/UniversidadEmail.php',
        'UniversidadTelefono' => 'Domain/ValueObjects/UniversidadTelefono.php',
        'UniversidadCantidad' => 'Domain/ValueObjects/UniversidadCantidad.php',

        'UniversidadModel' => 'Domain/Models/UniversidadModel.php',

        'CreateUniversidadUseCase' => 'Application/Ports/In/CreateUniversidadUseCase.php',
        'UpdateUniversidadUseCase' => 'Application/Ports/In/UpdateUniversidadUseCase.php',
        'GetUniversidadByIdUseCase' => 'Application/Ports/In/GetUniversidadByIdUseCase.php',
        'GetAllUniversidadesUseCase' => 'Application/Ports/In/GetAllUniversidadesUseCase.php',
        'DeleteUniversidadUseCase' => 'Application/Ports/In/DeleteUniversidadUseCase.php',

        'SaveUniversidadPort' => 'Application/Ports/Out/SaveUniversidadPort.php',
        'UpdateUniversidadPort' => 'Application/Ports/Out/UpdateUniversidadPort.php',
        'GetUniversidadByIdPort' => 'Application/Ports/Out/GetUniversidadByIdPort.php',
        'GetUniversidadByNombrePort' => 'Application/Ports/Out/GetUniversidadByNombrePort.php',
        'GetUniversidadByEmailPort' => 'Application/Ports/Out/GetUniversidadByEmailPort.php',
        'GetAllUniversidadesPort' => 'Application/Ports/Out/GetAllUniversidadesPort.php',
        'DeleteUniversidadPort' => 'Application/Ports/Out/DeleteUniversidadPort.php',

        'CreateUniversidadCommand' => 'Application/Services/Dto/Commands/CreateUniversidadCommand.php',
        'UpdateUniversidadCommand' => 'Application/Services/Dto/Commands/UpdateUniversidadCommand.php',
        'DeleteUniversidadCommand' => 'Application/Services/Dto/Commands/DeleteUniversidadCommand.php',
        'GetUniversidadByIdQuery' => 'Application/Services/Dto/Queries/GetUniversidadByIdQuery.php',
        'GetAllUniversidadesQuery' => 'Application/Services/Dto/Queries/GetAllUniversidadesQuery.php',

        'CreateUniversidadService' => 'Application/Services/CreateUniversidadService.php',
        'UpdateUniversidadService' => 'Application/Services/UpdateUniversidadService.php',
        'GetUniversidadByIdService' => 'Application/Services/GetUniversidadByIdService.php',
        'GetAllUniversidadesService' => 'Application/Services/GetAllUniversidadesService.php',
        'DeleteUniversidadService' => 'Application/Services/DeleteUniversidadService.php',
        'UniversidadApplicationMapper' => 'Application/Services/Mappers/UniversidadApplicationMapper.php',

        'UniversidadPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UniversidadPersistenceDto.php',
        'UniversidadEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UniversidadEntity.php',
        'UniversidadPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UniversidadPersistenceMapper.php',
        'UniversidadRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UniversidadRepositoryMySQL.php',

        'CreateUniversidadWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUniversidadRequest.php',
        'UpdateUniversidadWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUniversidadRequest.php',
        'UniversidadResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UniversidadResponse.php',
        'UniversidadWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UniversidadWebMapper.php',
        'UniversidadController' => 'Infrastructure/Entrypoints/Web/Controllers/UniversidadController.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];

        if (!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf('No se encontró el archivo para la clase %s en %s', $className, $filePath)
            );
        }

        require_once $filePath;
    }
}