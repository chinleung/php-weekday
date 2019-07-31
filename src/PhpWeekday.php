<?php

namespace ChinLeung\PhpWeekday;

use InvalidArgumentException;

class PhpWeekday
{
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
     * The list of supported locales.
     *
     * @var array
     */
    protected static $locales = [];

    /**
     * Constructor of the class.
     *
     * @param  string|int  $value
     * @param  string  $locale
     * @param  bool  $force
     * @return self
     */
    public function __construct($value, string $locale, bool $force = false)
    {
        if ($force || $this->hasNotLoadedLocales()) {
            static::refreshLocales();
        }

        $this->setLocale($locale)
             ->set($value);

        return $this;
    }

    /**
     * Retrieve the supported locales.
     *
     * @return array
     */
    public static function getLocales() : array
    {
        return static::$locales ?: static::refreshLocales();
    }

    /**
     * Retrieve the name of the weekday.
     *
     * @param  string  $locale
     * @return string
     */
    public function getName(string $locale = null) : string
    {
        if ($locale && $locale != $this->locale) {
            return $this->parseName($this->getValue(), $locale);
        }

        if (is_null($this->name)) {
            $this->name = $this->parseName($this->getValue());
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
    public static function getNameFromValue(int $value, string $locale) : string
    {
        return static::parse($value, $locale)->getName();
    }

    /**
     * Retrieve the names of every weekday for a locale.
     *
     * @param  string  $locale
     * @return array
     */
    public static function getNames(string $locale) : array
    {
        $path = __DIR__."/../resources/lang/$locale/names.php";

        if (! file_exists($path)) {
            static::throwNotSupportedLocaleException($locale);
        }

        return require $path;
    }

    /**
     * Retrieve the value of the weekday.
     *
     * @return int
     */
    public function getValue() : int
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
    public static function getValueFromName(string $name, string $locale) : string
    {
        return static::parse($name, $locale)->getValue();
    }

    /**
     * Check if the locales has been loaded.
     *
     * @return bool
     */
    public function hasLoadedLocales() : bool
    {
        return ! $this->hasNotLoadedLocales();
    }

    /**
     * Check if the locales has not been loaded yet.
     *
     * @return bool
     */
    public function hasNotLoadedLocales() : bool
    {
        return empty(static::$locales);
    }

    /**
     * Check if the locale is supported.
     *
     * @param  string  $locales
     * @return bool
     */
    public function isSupported(string $locale) : bool
    {
        return in_array($locale, static::$locales);
    }

    /**
     * Check if the locale is not supported.
     *
     * @param  string  $locales
     * @return bool
     */
    public function isNotSupported(string $locale) : bool
    {
        return ! $this->isSupported($locale);
    }

    /**
     * Create a new instance from a value.
     *
     * @param  string|int  $value
     * @param  string  $locale
     * @param  bool  $force
     * @return self
     */
    public static function parse($value, string $locale, bool $force = false)
    {
        return new static($value, $locale, $force);
    }

    /**
     * Parse the name of the weekday based on the value.
     *
     * @param  int  $value
     * @param  string  $locale
     * @return string
     */
    public function parseName(int $value, string $locale = null) : string
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
    public function parseValue(string $name, string $locale = null) : int
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
     * Refresh the list of supported locales.
     *
     * @return array
     */
    protected static function refreshLocales() : array
    {
        static::$locales = array_map(
            'basename',
            glob(__DIR__.'/../resources/lang/*') ?: []
        );

        return static::$locales;
    }

    /**
     * Set the weekday based on the integer or string value.
     *
     * @param  string|int  $value
     * @return self
     */
    public function set($value) : self
    {
        if (is_numeric($value)) {
            $this->value = $value;
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
    public function setLocale(string $locale) : self
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
    protected static function throwNotSupportedLocaleException(string $locale) : void
    {
        throw new InvalidArgumentException(
            "The locale ($locale) is not yet supported."
        );
    }
}