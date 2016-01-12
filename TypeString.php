<?php

namespace h4kuna;

/**
 * Description of String
 *
 * @author milan
 */
class TypeString extends BasicDataType {

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
