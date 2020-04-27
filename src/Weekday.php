<?php

namespace ChinLeung\Weekday;

use ChinLeung\VerboseLocalization\HasVerboseLocalization;
use InvalidArgumentException;

class Weekday
{
    use HasVerboseLocalization;

    /**
     * The locale of the application.
     *
     * @var string
     */
    protected $locale;

    /**
     * The name of the weekday.
     *
     * @var string
     */
    protected $name;

    /**
     * The value of the weekday.
     *
     * @var int
     */
    protected $value;

    /**
     * Constructor of the class.
     *
     * @param  string|int  $value
     * @param  string  $locale
     */
    public function __construct($value, string $locale)
    {
        $this->setLocale($locale)
             ->set($value);
    }

    /**
     * Retrieve the current locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Retrieve the supported locales.
     *
     * @return array
     */
    public static function getLocales(): array
    {
        return array_map(
            'basename',
            glob(__DIR__.'/../resources/lang/*') ?: []
        );
    }

    /**
     * Retrieve the name of the weekday.
     *
     * @param  string  $locale
     * @return string
     */
    public function getName(string $locale = null): string
    {
        if (! is_null($locale) && $locale != $this->locale) {
            return $this->getTranslationIn($locale);
        }

        if (is_null($this->name)) {
            $this->name = $this->getTranslationIn($this->locale);
        }

        return $this->name;
    }

    /**
     * Retrieve the name from a value.
     *
     * @param  int  $value
     * @param  string  $locale
     * @return string
     */
    public static function getNameFromValue(int $value, string $locale): string
    {
        return static::parse($value, $locale)->getName();
    }

    /**
     * Retrieve the names of every weekday for a locale.
     *
     * @param  string  $locale
     * @return array
     */
    public static function getNames(string $locale): array
    {
        $path = __DIR__."/../resources/lang/$locale/names.php";

        if (! file_exists($path)) {
            static::throwNotSupportedLocaleException($locale);
        }

        return require $path;
    }

    /**
     * Retrieve the translation in a specific locale.
     *
     * @param  string  $locale
     * @return string
     */
    public function getTranslationIn(string $locale): string
    {
        return $this->parseName($this->getValue(), $locale);
    }

    /**
     * Retrieve the value of the weekday.
     *
     * @return int
     */
    public function getValue(): int
    {
        if (is_null($this->value)) {
            $this->value = $this->parseValue($this->getName());
        }

        return $this->value;
    }

    /**
     * Retrieve the value from a name.
     *
     * @param  string  $name
     * @param  string  $locale
     * @return string
     */
    public static function getValueFromName(string $name, string $locale): string
    {
        return static::parse($name, $locale)->getValue();
    }

    /**
     * Check if the locale is supported.
     *
     * @param  string  $locale
     * @return bool
     */
    public function isSupported(string $locale): bool
    {
        return file_exists(__DIR__."/../resources/lang/$locale");
    }

    /**
     * Check if the locale is not supported.
     *
     * @param  string  $locale
     * @return bool
     */
    public function isNotSupported(string $locale): bool
    {
        return ! $this->isSupported($locale);
    }

    /**
     * Create a new instance from a value.
     *
     * @param  string|int  $value
     * @param  string  $locale
     * @return self
     */
    public static function parse($value, string $locale)
    {
        return new static($value, $locale);
    }

    /**
     * Parse the name of the weekday based on the value.
     *
     * @param  int  $value
     * @param  string  $locale
     * @return string
     */
    public function parseName(int $value, string $locale = null): string
    {
        if ($value < 0 || $value > 6) {
            throw new InvalidArgumentException(
                "The provided value ($value) is not a valid weekday."
            );
        }

        return array_values(static::getNames($locale ?: $this->locale))[$value];
    }

    /**
     * Parse the value from the weekday name.
     *
     * @param  string  $name
     * @param  string  $locale
     * @return int
     */
    public function parseValue(string $name, string $locale = null): int
    {
        $names = array_map(
            'strtolower',
            static::getNames($locale ?: $this->locale)
        );

        $value = array_search(
            strtolower($name),
            array_values($names)
        );

        if ($value === false) {
            throw new InvalidArgumentException(
                sprintf(
                    'The value could not be parsed for %s in %s.',
                    $name,
                    $locale ?: $this->locale
                )
            );
        }

        return $value;
    }

    /**
     * Set the weekday based on the integer or string value.
     *
     * @param  string|int  $value
     * @return self
     */
    public function set($value): self
    {
        if (is_numeric($value)) {
            $this->value = intval($value);
            $this->name = null;
        } else {
            $this->name = $value;
            $this->value = null;
        }

        return $this;
    }

    /**
     * Set the locale of the instance.
     *
     * @param  string  $locale
     * @return self
     */
    public function setLocale(string $locale): self
    {
        if ($locale != $this->locale) {
            if ($this->isNotSupported($locale)) {
                static::throwNotSupportedLocaleException($locale);
            }

            $this->name = null;
            $this->locale = $locale;
        }

        return $this;
    }

    /**
     * Throw an exception to let the user know that the locale is not yet
     * supported.
     *
     * @param  string  $locale
     * @return void
     */
    protected static function throwNotSupportedLocaleException(string $locale): void
    {
        throw new InvalidArgumentException(
            "The locale ($locale) is not yet supported."
        );
    }
}
