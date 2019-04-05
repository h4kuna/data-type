<?php declare(strict_types=1);

namespace h4kuna\DataType;

abstract class DataTypeException extends \Exception {}

class InvalidArgumentsException extends \RuntimeException {};

class LogicException extends \RuntimeException {}
