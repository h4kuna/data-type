<?php

namespace h4kuna\DataType\Object;

use h4kuna\DataType\DataTypeException;
use h4kuna\DataType\Validator;

/**
 * Base type integer as object
 *
 * @author Milan Matějček
 */
class Int extends Type
{

    /** @return int */
    protected function getEmptyValue()
    {
        return 0;
    }

    public function setValue($value)
    {
        $int = Validator\Int::fromString($value);
        if ($this->getFlags() & self::UNSIGNED && $int < $this->getEmptyValue()) {
            throw new DataTypeException('Integer must be unsigned, now is: ' . $int);
        }
        return parent::setValue($int);
    }

}
