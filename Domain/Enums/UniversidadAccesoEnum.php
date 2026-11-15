<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadAccesoException.php';

/**
 * Modalidad de acceso / admisión de la universidad.
 */
final class UniversidadAccesoEnum
{
    public const EXAMEN_ADMISION = 'EXAMEN_ADMISION';
    public const PRUEBAS_SABER_11 = 'PRUEBAS_SABER_11';
    public const INGRESO_DIRECTO = 'INGRESO_DIRECTO';
    public const MIXTO = 'MIXTO';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array(
            self::EXAMEN_ADMISION,
            self::PRUEBAS_SABER_11,
            self::INGRESO_DIRECTO,
            self::MIXTO,
        );
    }

    /**
     * Texto legible para mostrar en las vistas.
     */
    public static function label(string $value): string
    {
        $labels = array(
            self::EXAMEN_ADMISION => 'Examen de Admisión',
            self::PRUEBAS_SABER_11 => 'Pruebas Saber 11 / ICFES',
            self::INGRESO_DIRECTO => 'Ingreso Directo',
            self::MIXTO => 'Mixto',
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
            throw InvalidUniversidadAccesoException::becauseValueIsInvalid($value);
        }
    }
}