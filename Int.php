<?php

namespace h4kuna;

require_once 'DataType.php';

/**
 * Description of Int
 *
 * @author milan
 */
class Int extends DataType {

    public function setValue($v) {
        $this->inValue = $v;
        if (is_int($v)) {
            $this->value = $v;
        } elseif (is_numeric($v) && $v == intval($v)) {
            $this->value = intval($v);
        } else {
            $negative = substr($v, 0, 1) == '-';
            $v = preg_replace('~\W~', '', $v);
            if ($negative) {
                $v *= -1;
            }
            $this->value = intval($v);
        }

        if ($this->flags & parent::UNSIGNED && $this->value < 0) {
            $this->value = $this->emptyValue(); //exception?
        }

        return $this;
    }

    protected function emptyValue() {
        return 0;
    }

}

