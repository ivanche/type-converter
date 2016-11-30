<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

use Ivanche\Tests\Converter\FullnameToBarConverter;
use Ivanche\Tests\DummyClasses\BarClass;
use Ivanche\Tests\DummyClasses\Fullname;
use Ivanche\TypeConverter;
use PHPUnit\Framework\TestCase;

class TypeConverterTest extends TestCase
{
    /** @var TypeConverter */
    private static $typeConverter;

    private function setUpConverter()
    {
        self::$typeConverter = new TypeConverter();

        self::$typeConverter->registerConverter(new FullnameToBarConverter());
    }

    private function setUpAutoMapConverterStrictMode()
    {
        self::$typeConverter = new TypeConverter();

        self::$typeConverter->registerConverter(
            (new FullnameToBarConverter())->setAutoMapping(true)
        );
    }

    private function setUpAutoMapConverter()
    {
        self::$typeConverter = new TypeConverter();

        self::$typeConverter->registerConverter(
            (new FullnameToBarConverter())->setAutoMapping(true)->setStrictMode(false)
        );
    }

    public function testConvertFullnameToBar()
    {
        $this->setUpConverter();

        $firstname = 'firstname';
        $someValue = 'someValue';

        $fullname = (new Fullname())
            ->setFirstname($firstname)
            ->setSomeProperty($someValue)
        ;

        $convertedValue = self::$typeConverter->convert($fullname, BarClass::class);

        $this->assertInstanceOf(BarClass::class, $convertedValue);

        $this->assertAttributeEquals($firstname, 'a', $convertedValue);
        $this->assertAttributeEquals(null, 'someProperty', $convertedValue);
    }

    /**
     * @expectedException Ivanche\Exception\UnsupportedSourcePropertyException
     */
    public function testConvertFullnameToBarAutoMappingStrictMode()
    {
        $this->setUpAutoMapConverterStrictMode();

        $firstname = 'firstname';
        $someValue = 'someValue';

        $fullname = (new Fullname())
            ->setFirstname($firstname)
            ->setSomeProperty($someValue)
        ;

        self::$typeConverter->convert($fullname, BarClass::class);
    }

    public function testConvertFullnameToBarAutoMapping()
    {
        $this->setUpAutoMapConverter();

        $firstname = 'firstname';
        $someValue = 'someValue';

        $fullname = (new Fullname())
            ->setFirstname($firstname)
            ->setSomeProperty($someValue)
        ;

        $convertedValue = self::$typeConverter->convert($fullname, BarClass::class);

        $this->assertInstanceOf(BarClass::class, $convertedValue);

        $this->assertAttributeEquals($firstname, 'a', $convertedValue);
        $this->assertAttributeEquals($someValue, 'someProperty', $convertedValue);
    }
}