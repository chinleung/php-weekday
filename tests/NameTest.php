<?php

namespace ChinLeung\PhpWeekday\Tests;

use ChinLeung\PhpWeekday\PhpWeekday;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class NameTest extends TestCase
{
    /** @test **/
    public function it_can_retrieve_all_names_for_a_locale() : void
    {
        $this->assertEquals(
            ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            array_values(PhpWeekday::getNames('en'))
        );
    }

    /** @test **/
    public function it_can_retrieve_the_name_for_another_locale() : void
    {
        $weekday = new PhpWeekday('Sunday', 'en');

        $this->assertEquals('Dimanche', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_sunday() : void
    {
        $weekday = PhpWeekday::parse(0, 'en');

        $this->assertEquals('Sunday', $weekday->getName());
        $this->assertEquals('Dimanche', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_monday() : void
    {
        $weekday = PhpWeekday::parse(1, 'en');

        $this->assertEquals('Monday', $weekday->getName());
        $this->assertEquals('Lundi', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_tuesday() : void
    {
        $weekday = PhpWeekday::parse(2, 'en');

        $this->assertEquals('Tuesday', $weekday->getName());
        $this->assertEquals('Mardi', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_wednesday() : void
    {
        $weekday = PhpWeekday::parse(3, 'en');

        $this->assertEquals('Wednesday', $weekday->getName());
        $this->assertEquals('Mercredi', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_thursday() : void
    {
        $weekday = PhpWeekday::parse(4, 'en');

        $this->assertEquals('Thursday', $weekday->getName());
        $this->assertEquals('Jeudi', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_friday() : void
    {
        $weekday = PhpWeekday::parse(5, 'en');

        $this->assertEquals('Friday', $weekday->getName());
        $this->assertEquals('Vendredi', $weekday->getName('fr'));
    }

    /** @test **/
    public function it_can_parse_saturday() : void
    {
        $weekday = PhpWeekday::parse(6, 'en');

        $this->assertEquals('Saturday', $weekday->getName());
        $this->assertEquals('Samedi', $weekday->getName('fr'));
    }

    /** @test **/
    public function an_exception_is_thrown_for_non_valid_names() : void
    {
        $this->expectException(InvalidArgumentException::class);

        PhpWeekday::getValueFromName('Foo Bar', 'en');
    }

    /** @test **/
    public function it_can_retrieve_the_translation_via_verbose_methods() : void
    {
        $weekday = new PhpWeekday(0, 'en');

        foreach ($this->getVerboseMethods() as $method) {
            $this->assertNotNull($weekday->{$method->name}());
        }
    }

    /**
     * Retrieve the list of verbose methods.
     *
     * @return array
     */
    protected function getVerboseMethods() : array
    {
        return array_values(
            array_filter(
                (new ReflectionClass(PhpWeekday::class))->getMethods(),
                function ($method) {
                    return strpos($method->name, 'in') === 0;
                }
            )
        );
    }
}
