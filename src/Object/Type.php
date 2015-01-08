<?php

namespace h4kuna\DataType\Object;

/**
 * @author Milan Matějček
 */
abstract class Type implements IType
{

    private $value;
    private $flags = 0;

    public function __construct($value = NULL)
    {
        if ($value === NULL) {
            $value = $this->getEmptyValue();
        }

        $this->setValue($value);
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function setFlags($flag)
    {
        $this->flags = intval($flag);
        return $this;
    }

    public function getValue()
    {
        if ($this->getFlags() & self::EMPTY_IS_NULL && $this->value === $this->getEmptyValue()) {
            return NULL;
        }
        return $this->value;
    }

    public function setValue($value)
    {
        return $this->value = $value;
    }

    /**
     * 
     * @param mixed $value
     * @return self
     */
    public function createValue($value)
    {
        $object = new self($value);
        $object->setFlags($this->getFlags());
        return $object;
    }

    /** @return mixed */
    abstract protected function getEmptyValue();
}
