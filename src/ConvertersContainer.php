<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche;


use Ivanche\Converter\ConverterInterface;
use Ivanche\Exception\UnsupportedSourceException;

class ConvertersContainer
{
    /**
     * @var array
     */
    private $converters = [];

    /**
     * @param mixed $source
     * @param string $target
     * @param ConverterInterface $converter
     */
    public function addConverter($source, $target, ConverterInterface $converter)
    {
        $converterId = $this->createConverterId($source, $target);
        $this->converters[$converterId] = $converter;
    }

    /**
     * @param mixed $source
     * @param string $target
     */
    public function removeConverter($source, $target)
    {
        $converterId = $this->createConverterId($source, $target);
        if (key_exists($converterId, $this->converters)) {
            unset($this->converters[$converterId]);
        }
    }

    /**
     * @param mixed $source
     * @param string $target
     * @return ConverterInterface|null
     */
    public function getSuitableConverter($source, $target)
    {
        $converter = $this->getConverter($source, $target);

        if ($converter !== null) {
            return $converter;
        }

        foreach ($this->getAllClassesFromClassname($target) as $t) {
            foreach ($this->getAllClassesFromClassname($source) as $s) {
                $converter = $this->getConverter($s, $t);

                if ($converter !== null) {
                    $this->addConverter($s, $t, $converter);
                    return $converter;
                }
            }
        }

        return null;
    }

    /**
     * @param mixed $source
     * @param string $target
     * @return ConverterInterface|null
     */
    public function getConverter($source, $target)
    {
        $converterId = $this->createConverterId($source, $target);
        if (key_exists($converterId, $this->converters)) {
            return $this->converters[$converterId];
        }

        return null;
    }

    /**
     * @param mixed $source
     * @param string $target
     * @return string
     * @throws UnsupportedSourceException
     */
    private function createConverterId($source, $target)
    {
        $converterId = ":to:{$target}";

        if (is_object($source)) {
            $source = get_class($source);
        } elseif (!is_string($source)) {
            throw new UnsupportedSourceException();
        }

        return "{$source}:{$converterId}";
    }

    /**
     * @param string $class
     * @return array
     */
    private function getAllClassesFromClassname($class)
    {
        $classes = [];
        $classes[] = $class;

        $sourceClass = $class;
        while (!$parentClass = get_parent_class($sourceClass)) {
            $classes[] = $parentClass;
            $sourceClass = $parentClass;
        }

        return $classes;
    }
}