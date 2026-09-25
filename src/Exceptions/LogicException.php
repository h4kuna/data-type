<?php declare(strict_types = 1);

namespace h4kuna\DataType\Exceptions;

use LogicException as PhpLogicException;

/**
 * Programmer error, the code is used in a wrong way. Do not catch it, fix the code.
 */
final class LogicException extends PhpLogicException
{

}
