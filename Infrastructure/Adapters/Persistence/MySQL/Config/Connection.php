<?php

declare(strict_types=1);

/**
 * Crea la conexión PDO a partir de la configuración externa (.env o variables
 * del servidor). Soporta dos motores con el mismo SQL de los repositorios:
 *   - mysql : MySQL / MariaDB (desarrollo local)
 *   - pgsql : PostgreSQL (Supabase en producción)
 */
final class Connection
{
    private const SUPPORTED_DRIVERS = array('mysql', 'pgsql');

    private string $driver;
    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    private string $charset;
    private string $sslMode;

    public function __construct(
        string $host,
        int $port,
        string $database,
        string $username,
        string $password,
        string $charset = 'utf8mb4',
        string $driver = 'mysql',
        string $sslMode = ''
    ) {
        $driver = strtolower(trim($driver));

        if (!in_array($driver, self::SUPPORTED_DRIVERS, true)) {
            throw new InvalidArgumentException(
                'DB_DRIVER no soportado: ' . $driver . '. Use mysql o pgsql.'
            );
        }

        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->sslMode = trim($sslMode);
    }

    public function driver(): string
    {
        return $this->driver;
    }

    public function dsn(): string
    {
        if ($this->driver === 'pgsql') {
            $dsn = sprintf(
                'pgsql:host=%s;port=%d;dbname=%s',
                $this->host,
                $this->port,
                $this->database
            );

            // Supabase exige conexión cifrada: DB_SSLMODE=require
            return $this->sslMode !== '' ? $dsn . ';sslmode=' . $this->sslMode : $dsn;
        }

        return sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $this->host,
            $this->port,
            $this->database,
            $this->charset
        );
    }

    public function createPdo(): PDO
    {
        $pdo = new PDO(
            $this->dsn(),
            $this->username,
            $this->password,
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            )
        );

        if ($this->driver === 'pgsql') {
            $pdo->exec("SET client_encoding TO 'UTF8'");
        }

        return $pdo;
    }
}
