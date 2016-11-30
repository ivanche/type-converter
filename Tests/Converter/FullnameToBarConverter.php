<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Tests\Converter;


use Ivanche\Converter\AbstractConverter;
use Ivanche\Exception\UnsupportedSourceException;
use Ivanche\Tests\DummyClasses\BarClass;
use Ivanche\Tests\DummyClasses\Fullname;

class FullnameToBarConverter extends AbstractConverter
{
    public function __construct()
    {
        $this->sourceType = Fullname::class;
        $this->targetType = BarClass::class;
    }

    /**
     * @inheritDoc
     * @param Fullname $source
     * @param BarClass $autoMappedTargetObject
     */
    public function explicitConvert($source, $autoMappedTargetObject = null)
    {
        if ($autoMappedTargetObject !== null) {
            $bar = $autoMappedTargetObject;
        } else {
            $bar = new BarClass();
        }

        $bar
            ->setA($source->getFirstname())
        ;

        return $bar;
    }
}