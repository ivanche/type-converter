<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Tests\DummyClasses;


class FooClass
{
    /** @var string */
    private $a;

    /** @var integer */
    private $b;

    /** @var bool */
    private $c;

    /**
     * @return string
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param string $a
     * @return FooClass
     */
    public function setA($a)
    {
        $this->a = $a;
        return $this;
    }

    /**
     * @return int
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * @param int $b
     * @return FooClass
     */
    public function setB($b)
    {
        $this->b = $b;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isC()
    {
        return $this->c;
    }

    /**
     * @param boolean $c
     * @return FooClass
     */
    public function setC($c)
    {
        $this->c = $c;
        return $this;
    }
}