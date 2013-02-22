<?php

namespace h4kuna;

require_once 'DataType.php';

/**
 * Description of String
 *
 * @author milan
 */
class String extends BasicDataType {

    public function setValue($v) {
        $this->inValue = $v;
        $this->value = (string) $v;
        if ($this->flags & parent::TRIM) {
            $this->value = trim($this->value);
        }
        return $this;
    }

    protected function emptyValue() {
        return '';
    }

}