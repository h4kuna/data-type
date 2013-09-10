<?php

namespace h4kuna;

class Set extends DataType {

    private $set = array();

    const KEYS = 1;
    const AS_STRING = 3;

    /**
     * @param array $set
     */
    public function __construct(array $set = array()) {
        $this->clean();
        $this->set = $set;
    }

    /**
     * @param int $flag
     * @return string|array
     */
    public function getSet($flag = 0) {
        return $this->arraySetString($this->set, $flag);
    }

    /** @return array */
    public function intersect() {
        return array_intersect_key($this->set, $this->getValues());
    }

    /**
     * Transform array to string as set in mysql
     *
     * @param array $data
     * @param int $flag
     * @return string
     */
    private function arraySetString(array $data, $flag) {
        if ($flag & self::KEYS) {
            $data = array_keys($data);
            if ($flag & 2) {
                return implode(',', $data);
            }
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getValues() {
        return $this->getValue(0);
    }

    /**
     * @param int $flag
     * @return string|array
     */
    public function getValue($flag = self::AS_STRING) {
        $array = $this->value;
        $out = $this->arraySetString($this->value, $flag);
        if ($flag == self::AS_STRING) {
            $this->value = $out;
            $out = parent::getValue();
            $this->value = $array;
        }
        return $out;
    }

    /**
     *
     * @param string|array $value
     * @return this
     */
    public function setValue($value) {
        $this->inValue = $value;
        $this->clean();
        if (!$value) {
            return $this;
        }

        if (is_string($value)) {
            $this->value = array_fill_keys(explode(',', $value), TRUE);
        } elseif (is_array($value)) {
            foreach ($value as $k => $v) {
                if ($v) {
                    $this->value[$k] = TRUE;
                }
            }
        }
        return $this;
    }

    /** @return string */
    protected function emptyValue() {
        return '';
    }

    private function clean() {
        $this->value = array();
    }

}

