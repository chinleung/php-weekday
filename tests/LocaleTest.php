<?php

namespace ChinLeung\PhpWeekday\Tests;

use ChinLeung\PhpWeekday\PhpWeekday;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    /** @test **/
    public function an_exception_is_thrown_for_non_supported_locales() : void
    {
        $this->expectException(InvalidArgumentException::class);

        PhpWeekday::getNames('-');
    }

    /** @test **/
    public function an_exception_is_thrown_for_non_supported_locales_on_change() : void
    {
        $this->expectException(InvalidArgumentException::class);

        (new PhpWeekday(0, 'en'))->setLocale('-');
    }

    /** @test **/
    public function the_locale_of_the_instance_can_be_changed() : void
    {
        $instance = new PhpWeekday(0, 'en');

        foreach (PhpWeekday::getLocales() as $locale) {
            $names = array_values(PhpWeekday::getNames($locale));

            $this->assertEquals(
                $names[0],
                $instance->getName($locale)
            );
        }
    }

    /** @test **/
    public function it_can_retrieve_the_current_locale() : void
    {
        $instance = new PhpWeekday(0, 'en');

        $this->assertEquals('en', $instance->getLocale());
    }
}
