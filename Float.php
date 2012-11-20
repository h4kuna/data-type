<?php

namespace h4kuna;

require_once 'DataType.php';

/**
 * Description of Float
 *
 * @author milan
 */
class Float extends DataType {

    public function setValue($v) {
        if (is_float($v)) {
            $this->value = $v;
        } elseif (is_numeric($v)) {
            $this->value = floatval($v);
        } else {
            $negative = substr($v, 0, 1) == '-';
            preg_match('~[\.,]\d*$~', $v, $found);
            $v = preg_replace('~[\.,]\d*$|\W~', '', $v);
            if (!empty($found)) {
                $v .= str_replace(',', '.', $found[0]);
            }
            if ($negative) {
                $v *= -1;
            }
            $this->value = floatval($v);
        }

        if ($this->flags & parent::UNSIGNED && $this->value < 0) {
            $this->value = $this->emptyValue(); //exception?
        }

        return $this;
    }

    protected function emptyValue() {
        return 0.0;
    }

}

