<?php

namespace h4kuna;

/**
 * @example
 * $format = new Formating();
 *
 * foreach (array('0724323403', '+420724323403', '724-323-403', '+420-724-323-403', '+420 724 32 34 03', '00420 724 32 34 03') as $phone) {
 *     p($format->format($phone));
 * }
 *
 * @author Milan Matějček
 */
class Formating extends \Nette\Object {

    private $mask;
    private $regexp;
    private $delimiter;

    public function __construct() {
        $this->setPhone();
    }

    public function setUp($regexp, $mask, $delimiter = '') {
        $this->regexp = $regexp;
        $this->mask = $mask;
        $this->delimiter = $delimiter;
    }

    public function format($s) {
        $s = preg_replace('/' . $this->regexp . '/', '', $s);
        return implode($this->delimiter, preg_split('/^' . $this->mask . '$/', $s, -1, \PREG_SPLIT_DELIM_CAPTURE | \PREG_SPLIT_NO_EMPTY));
    }

    //-------------macros
    public function setPhone($mask = '(.*)(.{3})(.{3})(.{3})', $delimiter = ' ') {
        $this->setUp('(?!^\+)[^\d]', $mask, $delimiter);
    }

    public function setZip($mask = '(.{3})(.{2})', $delimiter = ' ') {
        $this->setUp('[^\d]', $mask, $delimiter);
    }

    public function url($s) {
        if (!$s) {
            return NULL;
        }
        $url = new \Nette\Http\Url($s);
        if (!$url->getScheme()) {
            $url->setScheme('http');
        }
        return $url->absoluteUrl;
    }

}

