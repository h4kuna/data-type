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

    protected $value;
    protected $flags = 0;
    protected $inValue;

    public function __construct($value = NULL) {
        $this->setValue($value);
    }

    abstract public function setValue($v);

    abstract protected function emptyValue();

    public function getInValue() {
        return $this->inValue;
    }

    public function getValue() {
        if ($this->flags & self::EMPTY_IS_NULL && $this->value == $this->emptyValue()) {
            return NULL;
        }
        return $this->value;
    }

    public function setFlags($v) {
        $this->flags = $v;
        return $this;
    }

    public function __toString() {
        return (string) $this->getValue();
    }

}

