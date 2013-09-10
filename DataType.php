<?php

namespace h4kuna;

use Nette\Object;

/**
 * Description of DataType
 *
 * @author milan
 */
abstract class DataType extends Object {

    const EMPTY_IS_NULL = 1;
    const UNSIGNED = 2;
    const TRIM = 4;

    /** @var mixed */
    protected $value;

    /** @var int */
    protected $flags;

    /** @var mixed */
    protected $inValue;

    /**
     * @param mixed $value
     * @param int $flag
     */
    public function __construct($value = NULL, $flag = 0) {
        if ($value !== NULL) {
            $this->setValue($value);
        }
        $this->setFlags($flag);
    }

    /**
     * @param mixed $v
     * @return this
     */
    abstract public function setValue($v);

    /**
     * return default emtpy value
     * @return mixed
     */
    abstract protected function emptyValue();

    /**
     * Original value
     * 
     * @return mixed
     */
    public function getInValue() {
        return $this->inValue;
    }

    /** @return NULL|mixed */
    public function getValue() {
        if ($this->flags & self::EMPTY_IS_NULL && $this->value == $this->emptyValue()) {
            return NULL;
        }
        return $this->value;
    }

    /**
     * @param int $v
     * @return this
     */
    public function setFlags($v) {
        if ($v === NULL) {
            $v = self::EMPTY_IS_NULL;
        } elseif (!is_int($v)) {
            $v = 0;
        }
        $this->flags = $v;
        return $this;
    }

    /**
     * Magic call
     *
     * @return string
     */
    public function __toString() {
        return (string) $this->getValue();
    }

}

