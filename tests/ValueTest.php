<?php

namespace ChinLeung\PhpWeekday\Tests;

use ChinLeung\PhpWeekday\PhpWeekday;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    /** @test **/
    public function it_can_convert_sunday_to_its_value() : void
    {
        foreach (PhpWeekday::getLocales() as $locale) {
            $this->assertEquals(
                0,
                PhpWeekday::getValueFromName(
                    PhpWeekday::getNameFromValue(0, $locale),
                    $locale
                )
            );
        }
    }

    /** @test **/
    public function an_exception_is_thrown_for_non_valid_values() : void
    {
        $this->expectException(InvalidArgumentException::class);

        PhpWeekday::getNameFromValue(7, 'en');
    }
}
