<?php

namespace ChinLeung\Weekday\Tests;

use ChinLeung\Weekday\Weekday;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    /** @test **/
    public function an_exception_is_thrown_for_non_supported_locales(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Weekday::getNames('-');
    }

    /** @test **/
    public function an_exception_is_thrown_for_non_supported_locales_on_change(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new Weekday(0, 'en'))->setLocale('-');
    }

    /** @test **/
    public function the_locale_of_the_instance_can_be_changed(): void
    {
        $instance = new Weekday(0, 'en');

        foreach (Weekday::getLocales() as $locale) {
            $names = array_values(Weekday::getNames($locale));

            $this->assertEquals(
                $names[0],
                $instance->getName($locale)
            );
        }
    }

    /** @test **/
    public function it_can_retrieve_the_current_locale(): void
    {
        $instance = new Weekday(0, 'en');

        $this->assertEquals('en', $instance->getLocale());
    }
}
