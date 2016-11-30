<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Converter;


interface AutoMappingInterface
{
    /**
     * @return bool
     */
    public function isAutoMapping();

    /**
     * @param bool $autoMapping
     * @return mixed
     */
    public function setAutoMapping($autoMapping);

    /**
     * @return bool
     */
    public function isStrictMode();

    /**
     * @param bool $strictMode
     * @return mixed
     */
    public function setStrictMode($strictMode);
}