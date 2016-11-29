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
    /**
     * @inheritDoc
     * @param Fullname $source
     */
    public function convert($source)
    {
        if (!$source instanceof Fullname) {
            throw new UnsupportedSourceException();
        }

        $bar = new BarClass();
        $bar
            ->setSomeProperty($source->getSomeProperty())
            ->setA($source->getFirstname())
        ;

        return $bar;
    }
}