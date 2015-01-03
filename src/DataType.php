<?php

namespace h4kuna\DataType;

use Nette\Object;

/**
 * 
 * 
 * @author Milan Matějček
 */
abstract class DataType extends Object implements IDataType
{

    /** @var mixed */
    protected $value;

    /** @var int */
    private $flags;

    /**
     * @param mixed $value
     * @param int $flag
     */
    public function __construct($value = NULL, $flag = 0)
    {
        $this->setFlags($flag);
        $this->value = $this->prepareValue($value);
    }

    /**
     * Return default emtpy value
     * 
     * @return mixed
     */
    abstract protected function getEmptyValue();

    abstract protected function prepareValue($value);

    /** @return int */
    public function getFlags()
    {
        return $this->flags;
    }

    /** @return NULL|mixed */
    public function getValue()
    {
        if ($this->flags & self::EMPTY_IS_NULL && $this->value === $this->getEmptyValue()) {
            return NULL;
        }
        return $this->value;
    }

    /**
     * @param int $int
     * @return self
     */
    public function setFlags($int)
    {
        $this->flags = intval($int);
        return $this;
    }

    /**
     * @param mixed $v
     * @return self
     */
    public function setValue($v)
    {
        return new static($v, $this->getFlags());
    }

    /**
     * Magic call
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

}
