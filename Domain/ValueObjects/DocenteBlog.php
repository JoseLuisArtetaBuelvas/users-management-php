<?php

declare(strict_types=1);

require_once __DIR__ . '/../Exceptions/InvalidDocenteBlogException.php';

/**
 * Blog o sitio web personal del docente. Es opcional: puede estar vacío,
 * pero si se informa debe ser una URL http(s) válida.
 */
final class DocenteBlog
{
    private string $value;

    public function __construct(string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue !== '' && !self::isValidUrl($normalizedValue)) {
            throw InvalidDocenteBlogException::becauseUrlIsInvalid($normalizedValue);
        }

        $this->value = $normalizedValue;
    }

    public static function empty(): self
    {
        return new self('');
    }

    private static function isValidUrl(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, array('http', 'https'), true);
    }

    public function isEmpty(): bool
    {
        return $this->value === '';
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(DocenteBlog $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
