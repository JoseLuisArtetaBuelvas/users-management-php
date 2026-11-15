<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidUniversidadWebException.php';

/**
 * Sitio web de la universidad: obligatorio y con URL http(s) válida.
 */
final class UniversidadWeb
{
    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw InvalidUniversidadWebException::becauseValueIsEmpty();
        }

        $scheme = strtolower((string) parse_url($normalizedValue, PHP_URL_SCHEME));

        if (filter_var($normalizedValue, FILTER_VALIDATE_URL) === false
            || !in_array($scheme, array('http', 'https'), true)) {
            throw InvalidUniversidadWebException::becauseUrlIsInvalid($normalizedValue);
        }

        $this->value = $normalizedValue;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(UniversidadWeb $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
