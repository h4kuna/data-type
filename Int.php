<?php

namespace h4kuna;

/**
 * Base type integer as object
 *
 * @author Milan Matějček
 */
class Int extends DataType {

    /**
     * @param string|float|int $v
     * @return this
     */
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

    /** @return int */
    protected function emptyValue() {
        return 0;
    }

}

