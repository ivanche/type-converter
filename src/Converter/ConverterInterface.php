<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Converter;


interface ConverterInterface
{
    /**
     * @return string
     */
    public function getSourceType();

    /**
     * @return string
     */
    public function getTargetType();

    /**
     * @param mixed $source
     * @return mixed
     */
    public function convert($source);
}