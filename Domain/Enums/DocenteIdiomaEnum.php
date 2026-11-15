<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteIdiomaException.php';

/**
 * Idioma principal en el que el docente imparte sus clases.
 */
final class DocenteIdiomaEnum
{
    public const ESPANOL = 'ESPANOL';
    public const INGLES = 'INGLES';
    public const FRANCES = 'FRANCES';
    public const PORTUGUES = 'PORTUGUES';
    public const ALEMAN = 'ALEMAN';
    public const OTRO = 'OTRO';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array(
            self::ESPANOL,
            self::INGLES,
            self::FRANCES,
            self::PORTUGUES,
            self::ALEMAN,
            self::OTRO,
        );
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidDocenteIdiomaException::becauseValueIsInvalid($value);
        }
    }
}
