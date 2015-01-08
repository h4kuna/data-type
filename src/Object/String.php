<?php

namespace h4kuna\DataType\Object;

/**
 * @author Milan Matějček
 */
class String extends Type
{

    protected function getEmptyValue()
    {
        return '';
    }

    protected function setValue($value)
    {
        $out = (string) $value;
        if ($this->getFlags() & self::TRIM) {
            return trim($out);
        }
        return parent::setValue($out);
    }

}
