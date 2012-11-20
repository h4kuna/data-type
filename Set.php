<?php

namespace h4kuna;

class Set extends DataType {

    private $values = array();
    private $set = array();

    public function __construct(array $set) {
        $this->set = $set;
    }

    public function getSet() {
        return $this->set;
    }

    /**
     * množina jako pole
     * @return array
     */
    public function getValues($keys = FALSE) {
        if ($keys) {
            return array_keys($this->values);
        }
        return $this->values;
    }

    /**
     *
     * @param string|array $value
     * @return \h4kuna\Set
     */
    public function setValue($value) {
        $this->clean();
        if ($value === NULL) {
            return $this;
        }

        if (is_string($value)) {
            $this->values = array_fill_keys(explode(',', $value), TRUE);
            $this->value = $value;
        } elseif (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($v) {
                    if ($this->value) {
                        $this->value .= ',';
                    }
                    $this->value .= $k;
                    $this->values[$k] = $this->set[$k];
                }
            }
        }
        return $this;
    }

    protected function emptyValue() {
        return '';
    }

    private function clean() {
        $this->value = $this->emptyValue();
        $this->values = array();
    }

}

