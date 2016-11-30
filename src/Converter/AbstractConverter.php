<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Converter;


use Ivanche\Exception\UnsupportedSourceException;
use Ivanche\Exception\UnsupportedSourcePropertyException;
use Ivanche\Utils\ReflectionHelper;

abstract class AbstractConverter implements ConverterInterface, AutoMappingInterface
{
    protected $sourceType;
    protected $targetType;
    protected $autoMapping = false;
    protected $strictMode = true;

    /**
     * @inheritDoc
     */
    public function getSourceType()
    {
        return (string)$this->sourceType;
    }

    /**
     * @inheritDoc
     */
    public function getTargetType()
    {
        return (string)$this->targetType;
    }

    /**
     * @inheritdoc
     */
    public function convert($source)
    {
        $this->isSupportedSource($source);

        $autoMappedTargetObj = null;

        if ($this->isAutoMapping()) {
            $autoMappedTargetObj = $this->autoMappingConvert($source);
        }

        return $this->explicitConvert($source, $autoMappedTargetObj);
    }

    /**
     * @inheritDoc
     */
    public function isAutoMapping()
    {
        return (bool)$this->autoMapping;
    }

    /**
     * @inheritDoc
     */
    public function setAutoMapping($autoMapping)
    {
        $this->autoMapping = (bool)$autoMapping;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isStrictMode()
    {
        return (bool)$this->strictMode;
    }

    /**
     * @inheritDoc
     */
    public function setStrictMode($strictMode)
    {
        $this->strictMode = (bool)$strictMode;
        return $this;
    }

    /**
     * @param mixed $source
     * @return mixed
     */
    protected function autoMappingConvert($source)
    {
        $targetClass = $this->getTargetType();
        $targetObj = new $targetClass;

        $this->autoMappingPopulate($source, $targetObj);

        return $targetObj;
    }

    /**
     * @param mixed $source
     * @param mixed $target
     * @throws UnsupportedSourcePropertyException
     */
    protected function autoMappingPopulate($source, $target)
    {
        $reflectionTargetClass = new \ReflectionClass($target);

        $reflectionSourceClass = new \ReflectionClass($source);
        foreach (ReflectionHelper::getPublicPropertiesAndGetters($reflectionSourceClass, $source) as $name => $value) {

            $targetProperty = $reflectionTargetClass->hasProperty($name) ?
                $reflectionTargetClass->getProperty($name) : null;

            if ($targetProperty && $targetProperty->isPublic()) {
                $target->{$name} = $value;
                continue;
            }

            $setterMethodName = "set{$name}";
            $targetSetter = $reflectionTargetClass->hasMethod($setterMethodName) ?
                $reflectionTargetClass->getMethod($setterMethodName) : null;

            if ($targetSetter && !$targetSetter->isPrivate()) {
                call_user_func([$target, $setterMethodName], $value);
                continue;
            }

            if ($this->isStrictMode()) {
                throw new UnsupportedSourcePropertyException();
            }
        }

    }

    /**
     * @param mixed $source
     * @throws UnsupportedSourceException
     */
    protected function isSupportedSource($source)
    {
        if (!is_object($source) || get_class($source) !== $this->getSourceType()) {
            throw new UnsupportedSourceException();
        }
    }

    /**
     * @param mixed $source
     * @param object|null $autoMappedTargetObject
     * @return mixed
     */
    abstract protected function explicitConvert($source, $autoMappedTargetObject = null);
}