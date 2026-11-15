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

        // ── Docente (ejercicio 3) ─────────────────────────────────
        'InvalidDocenteIdException' => 'Domain/Exceptions/InvalidDocenteIdException.php',
        'InvalidDocenteNombreException' => 'Domain/Exceptions/InvalidDocenteNombreException.php',
        'InvalidDocenteEmailException' => 'Domain/Exceptions/InvalidDocenteEmailException.php',
        'InvalidDocenteTelefonoException' => 'Domain/Exceptions/InvalidDocenteTelefonoException.php',
        'InvalidDocenteBlogException' => 'Domain/Exceptions/InvalidDocenteBlogException.php',
        'InvalidDocenteAniosExperienciaException' => 'Domain/Exceptions/InvalidDocenteAniosExperienciaException.php',
        'InvalidDocenteCampoTextoException' => 'Domain/Exceptions/InvalidDocenteCampoTextoException.php',
        'InvalidDocenteEscalafonException' => 'Domain/Exceptions/InvalidDocenteEscalafonException.php',
        'InvalidDocenteIdiomaException' => 'Domain/Exceptions/InvalidDocenteIdiomaException.php',
        'DocenteAlreadyExistsException' => 'Domain/Exceptions/DocenteAlreadyExistsException.php',
        'DocenteNotFoundException' => 'Domain/Exceptions/DocenteNotFoundException.php',

        'DocenteEscalafonEnum' => 'Domain/Enums/DocenteEscalafonEnum.php',
        'DocenteIdiomaEnum' => 'Domain/Enums/DocenteIdiomaEnum.php',

        'DocenteId' => 'Domain/ValueObjects/DocenteId.php',
        'DocenteNombre' => 'Domain/ValueObjects/DocenteNombre.php',
        'DocenteEmail' => 'Domain/ValueObjects/DocenteEmail.php',
        'DocenteTelefono' => 'Domain/ValueObjects/DocenteTelefono.php',
        'DocenteBlog' => 'Domain/ValueObjects/DocenteBlog.php',
        'DocenteAniosExperiencia' => 'Domain/ValueObjects/DocenteAniosExperiencia.php',
        'DocenteCampoTexto' => 'Domain/ValueObjects/DocenteCampoTexto.php',

        'DocenteModel' => 'Domain/Models/DocenteModel.php',

        'CreateDocenteUseCase' => 'Application/Ports/In/CreateDocenteUseCase.php',
        'UpdateDocenteUseCase' => 'Application/Ports/In/UpdateDocenteUseCase.php',
        'GetDocenteByIdUseCase' => 'Application/Ports/In/GetDocenteByIdUseCase.php',
        'GetAllDocentesUseCase' => 'Application/Ports/In/GetAllDocentesUseCase.php',
        'DeleteDocenteUseCase' => 'Application/Ports/In/DeleteDocenteUseCase.php',

        'SaveDocentePort' => 'Application/Ports/Out/SaveDocentePort.php',
        'UpdateDocentePort' => 'Application/Ports/Out/UpdateDocentePort.php',
        'GetDocenteByIdPort' => 'Application/Ports/Out/GetDocenteByIdPort.php',
        'GetDocenteByEmailPort' => 'Application/Ports/Out/GetDocenteByEmailPort.php',
        'GetAllDocentesPort' => 'Application/Ports/Out/GetAllDocentesPort.php',
        'DeleteDocentePort' => 'Application/Ports/Out/DeleteDocentePort.php',

        'CreateDocenteCommand' => 'Application/Services/Dto/Commands/CreateDocenteCommand.php',
        'UpdateDocenteCommand' => 'Application/Services/Dto/Commands/UpdateDocenteCommand.php',
        'DeleteDocenteCommand' => 'Application/Services/Dto/Commands/DeleteDocenteCommand.php',
        'GetDocenteByIdQuery' => 'Application/Services/Dto/Queries/GetDocenteByIdQuery.php',
        'GetAllDocentesQuery' => 'Application/Services/Dto/Queries/GetAllDocentesQuery.php',

        'CreateDocenteService' => 'Application/Services/CreateDocenteService.php',
        'UpdateDocenteService' => 'Application/Services/UpdateDocenteService.php',
        'GetDocenteByIdService' => 'Application/Services/GetDocenteByIdService.php',
        'GetAllDocentesService' => 'Application/Services/GetAllDocentesService.php',
        'DeleteDocenteService' => 'Application/Services/DeleteDocenteService.php',
        'DocenteApplicationMapper' => 'Application/Services/Mappers/DocenteApplicationMapper.php',

        'DocentePersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/DocentePersistenceDto.php',
        'DocenteEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/DocenteEntity.php',
        'DocentePersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/DocentePersistenceMapper.php',
        'DocenteRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/DocenteRepositoryMySQL.php',

        'CreateDocenteWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateDocenteRequest.php',
        'UpdateDocenteWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateDocenteRequest.php',
        'DocenteResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/DocenteResponse.php',
        'DocenteWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/DocenteWebMapper.php',
        'DocenteController' => 'Infrastructure/Entrypoints/Web/Controllers/DocenteController.php',
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