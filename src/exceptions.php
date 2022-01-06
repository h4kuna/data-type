<?php declare(strict_types=1);

namespace h4kuna\DataType;

class DataTypeException extends \Exception {}

class InvalidArgumentsException extends DataTypeException {}

class LogicException extends \RuntimeException {}
