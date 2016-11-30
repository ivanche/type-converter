<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Utils;


class ReflectionHelper
{
    /**
     * @param \ReflectionClass $reflectionClass
     * @param object $object
     * @return array
     */
    public static function getPublicPropertiesAndGetters(\ReflectionClass $reflectionClass, $object)
    {
        $propertiesAndGetters = [];

        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $propertiesAndGetters[$property->getName()] = $property->getValue();
        }

        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isAbstract() || $method->isStatic()) {
                continue;
            }

            $methodName = $method->getName();

            if (preg_match('%^(?:get|is)(?<name>.+)$%i', $methodName, $matches) === 1) {
                $propName = lcfirst($matches['name']);
                try {
                    $propertiesAndGetters[$propName] = $method->invoke($object);
                } catch (\ReflectionException $e) {
                    continue;
                }
            }
        }

        return $propertiesAndGetters;
    }
}