<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Converter;


abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @inheritdoc
     */
    abstract public function convert($source);
}