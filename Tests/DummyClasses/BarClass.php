<?php
/**
 * @author IvanChe <ivanche.freelancer@gmail.com>
 */

namespace Ivanche\Tests\DummyClasses;


class BarClass extends FooClass
{
    /** @var string */
    private $someProperty;

    /**
     * @return string
     */
    public function getSomeProperty()
    {
        return $this->someProperty;
    }

    /**
     * @param string $someProperty
     * @return $this
     */
    public function setSomeProperty($someProperty)
    {
        $this->someProperty = $someProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getA()
    {
        return $this->getA();
    }

    /**
     * @param string $a
     * @return $this
     */
    public function setA($a)
    {
        parent::setA($a);
        return $this;
    }

    /**
     * @return int
     */
    public function getB()
    {
        return $this->getB();
    }

    /**
     * @param int $b
     * @return $this
     */
    public function setB($b)
    {
        parent::setB($b);
        return $this;
    }

    /**
     * @return boolean
     */
    public function isC()
    {
        return $this->isC();
    }

    /**
     * @param boolean $c
     * @return $this
     */
    public function setC($c)
    {
        parent::setC($c);
        return $this;
    }
}