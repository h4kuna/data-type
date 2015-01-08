<?php

namespace h4kuna\DataType\Object;

use h4kuna\DataType\DataTypeException;
use h4kuna\DataType\Validator;

/**
 * @author Milan Matějček
 */
class Float extends Type
{

    /** @return float */
    protected function getEmptyValue()
    {
        return 0.0;
    }

    public function setValue($value)
    {
        $float = Validator\Float::fromString($value);
        if ($this->getFlags() & self::UNSIGNED && $float < $this->getEmptyValue()) {
            throw new DataTypeException('Float must be unsigned, now is: ' . $float);
        }
        return parent::setValue($float);
    }

}
