<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

use Ivanche\ConvertersContainer;
use Ivanche\Tests\Converter\FullnameToBarConverter;
use Ivanche\Tests\DummyClasses\BarClass;
use Ivanche\Tests\DummyClasses\Fullname;
use PHPUnit\Framework\TestCase;

class ConvertersContainerTest extends TestCase
{
    public function testAddConverterStringSource()
    {
        $convertersContainer = new ConvertersContainer();

        $this->assertNull($convertersContainer->getConverter(Fullname::class, BarClass::class));

        $convertersContainer->addConverter(new FullnameToBarConverter());

        $this->assertInstanceOf(FullnameToBarConverter::class,
            $convertersContainer->getConverter(Fullname::class, BarClass::class));
    }

    public function testAddConverterObjectSource()
    {
        $convertersContainer = new ConvertersContainer();

        $this->assertNull($convertersContainer->getConverter(Fullname::class, BarClass::class));

        $convertersContainer->addConverter(new FullnameToBarConverter());

        $this->assertInstanceOf(FullnameToBarConverter::class,
            $convertersContainer->getConverter(new Fullname(), BarClass::class));
    }
}