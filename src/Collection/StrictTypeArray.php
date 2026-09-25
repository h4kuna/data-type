<?php declare(strict_types=1);

namespace h4kuna\DataType\Collection;

use h4kuna\DataType\Basic\Bools;
use h4kuna\DataType\Basic\Floats;
use h4kuna\DataType\Basic\Integer;
use h4kuna\DataType\Basic\Strings;
use h4kuna\DataType\Exceptions\InvalidTypeException;

final class StrictTypeArray
{
	/**
	 * @param array<array<mixed>|bool|float|int|string|null> $data
	 */
	public function __construct(private /* readonly */ array $data)
	{
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function stringNull(string $name): ?string
	{
		return isset($this->data[$name]) ? Strings::from($this->data[$name]) : null;
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function string(string $name): string
	{
		array_key_exists($name, $this->data) || throw InvalidTypeException::createInvalidString($name);

		return Strings::from($this->data[$name]);
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function float(string $name): float
	{
		array_key_exists($name, $this->data) || throw InvalidTypeException::createInvalidFloat($name);

		return Floats::from($this->data[$name]);
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function floatNull(string $name): ?float
	{
		return isset($this->data[$name]) ? Floats::from($this->data[$name]) : null;
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function int(string $name): int
	{
		array_key_exists($name, $this->data) || throw InvalidTypeException::createInvalidInt($name);

		return Integer::from($this->data[$name]);
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function intNull(string $name): ?int
	{
		return isset($this->data[$name]) ? Integer::from($this->data[$name]) : null;
	}


	/**
	 * @throws InvalidTypeException
	 */
	public function bool(string|int $name): bool
	{
		if (isset($this->data[$name]) === false) {
			return false;
		}

		return Bools::from($this->data[$name]);
	}


	/**
	 * @return array<mixed>|null
	 * @throws InvalidTypeException
	 */
	public function arrayNull(string $name): ?array
	{
		return isset($this->data[$name]) ? $this->array($name) : null;
	}


	/**
	 * @return array<mixed>
	 * @throws InvalidTypeException
	 */
	public function array(string $name): array
	{
		$value = $this->data[$name] ?? null;
		if (is_array($value) === false) {
			throw InvalidTypeException::createInvalidArray($name);
		}

		return $value;
	}

}
