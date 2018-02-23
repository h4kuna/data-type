<?php

namespace h4kuna\DataType;

/**
 * @author Milan Matějček
 */
class DataTypeException extends \Exception {}

class InvalidArgumentsException extends DataTypeException {}

class LogicException extends \RuntimeException {}
