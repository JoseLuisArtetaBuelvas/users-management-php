<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteCampoTextoException.php';

/**
 * Texto descriptivo obligatorio del docente: título profesional y área de trabajo.
 */
final class DocenteCampoTexto
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 150;

    private string $value;

    public function __construct(string $value, string $campo)
    {
        $normalizedValue = preg_replace('/\s+/u', ' ', trim($value)) ?? '';

        if ($normalizedValue === '') {
            throw InvalidDocenteCampoTextoException::becauseValueIsEmpty($campo);
        }

        if (mb_strlen($normalizedValue) < self::MIN_LENGTH) {
            throw InvalidDocenteCampoTextoException::becauseLengthIsTooShort($campo, self::MIN_LENGTH);
        }

        if (mb_strlen($normalizedValue) > self::MAX_LENGTH) {
            throw InvalidDocenteCampoTextoException::becauseLengthIsTooLong($campo, self::MAX_LENGTH);
        }

        $this->value = $normalizedValue;
    }

    public static function profesional(string $value): self
    {
        return new self($value, 'profesional');
    }

    public static function areaTrabajo(string $value): self
    {
        return new self($value, 'área de trabajo');
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(DocenteCampoTexto $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
