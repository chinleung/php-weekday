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

        $this->assertEquals('Sunday', $instance->getName());

        $instance->setLocale('fr');

        $this->assertEquals('Dimanche', $instance->getName());
    }
}
