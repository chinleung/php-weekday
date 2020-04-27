<?php

namespace ChinLeung\Weekday\Tests;

use ChinLeung\Weekday\Weekday;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    /** @test **/
    public function it_can_convert_sunday_to_its_value() : void
    {
        foreach (Weekday::getLocales() as $locale) {
            $this->assertEquals(
                0,
                Weekday::getValueFromName(
                    Weekday::getNameFromValue(0, $locale),
                    $locale
                )
            );
        }
    }

    /** @test **/
    public function an_exception_is_thrown_for_non_valid_values() : void
    {
        $this->expectException(InvalidArgumentException::class);

        Weekday::getNameFromValue(7, 'en');
    }
}
