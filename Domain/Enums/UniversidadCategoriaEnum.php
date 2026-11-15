<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadCategoriaException.php';

/**
 * Naturaleza de la universidad (igual que en la Unidad 1).
 */
final class UniversidadCategoriaEnum
{
    public const PUBLICA = 'PUBLICA';
    public const PRIVADA = 'PRIVADA';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array(
            self::PUBLICA,
            self::PRIVADA,
        );
    }

    /**
     * Texto legible para mostrar en las vistas.
     */
    public static function label(string $value): string
    {
        $labels = array(
            self::PUBLICA => 'Pública',
            self::PRIVADA => 'Privada',
        );

        return $labels[$value] ?? $value;
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidUniversidadCategoriaException::becauseValueIsInvalid($value);
        }
    }
}