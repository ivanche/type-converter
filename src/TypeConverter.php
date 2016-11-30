<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche;


use Ivanche\Converter\ConverterInterface;
use Ivanche\Exception\ConversionException;

class TypeConverter
{
    /**
     * @var ConvertersContainer
     */
    private $convertersContainer;

    /**
     * @param ConvertersContainer|null $convertersContainer
     */
    public function __construct(ConvertersContainer $convertersContainer = null)
    {
        if ($convertersContainer === null) {
            $convertersContainer = new ConvertersContainer();
        }
        $this->convertersContainer = $convertersContainer;
    }


    /**
     * @param mixed $source
     * @param string $target
     * @return mixed
     * @throws ConversionException
     */
    public function convert($source, $target)
    {
        if ($source === null || $target === null) {
            return null;
        }

        $converter = $this->convertersContainer->getSuitableConverter($source, $target);

        if ($converter === null) {
            throw new ConversionException("There is no suitable converter");
        }

        return $converter->convert($source);
    }

    /**
     * @param ConverterInterface $converter
     */
    public function registerConverter(ConverterInterface $converter)
    {
        $this->convertersContainer->addConverter($converter);
    }

    /**
     * @param mixed $source
     * @param string $target
     */
    public function removeConverter($source, $target)
    {
        $this->convertersContainer->removeConverter($source, $target);
    }
}