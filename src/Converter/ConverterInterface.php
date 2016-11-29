<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Converter;


interface ConverterInterface
{
    /**
     * @param mixed $source
     * @return mixed
     */
    public function convert($source);
}