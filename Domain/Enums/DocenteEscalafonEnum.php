<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteEscalafonException.php';

/**
 * Categorías del escalafón docente universitario.
 */
final class DocenteEscalafonEnum
{
    public const AUXILIAR = 'AUXILIAR';
    public const ASISTENTE = 'ASISTENTE';
    public const ASOCIADO = 'ASOCIADO';
    public const TITULAR = 'TITULAR';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array(
            self::AUXILIAR,
            self::ASISTENTE,
            self::ASOCIADO,
            self::TITULAR,
        );
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidDocenteEscalafonException::becauseValueIsInvalid($value);
        }
    }
}
