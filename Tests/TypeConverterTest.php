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

    public static function setUpBeforeClass()
    {
        self::$typeConverter = new TypeConverter();
        self::$typeConverter->registerConverter(Fullname::class, BarClass::class, new FullnameToBarConverter());
    }

    public function testConvertFullnameToBar()
    {
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