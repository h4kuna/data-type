<?php

namespace h4kuna;

require_once 'DataType.php';

class Set extends DataType {

    private $values = array();
    private $set = array();

    /**
     *
     * @param array $set
     */
    public function __construct($set = array()) {
        $this->set = $set;
    }

    public function getSet($keys = FALSE) {
        if ($keys) {
            return array_keys($this->set);
        }
        return $this->set;
    }

    public function intersect() {
        return array_intersect_key($this->set, $this->getValues());
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
        if (!$value) {
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
                    $this->values[$k] = TRUE;
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

