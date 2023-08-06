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
	 * @param array<string, mixed> $data
	 */
	public function __construct(private /* readonly */ array $data)
	{
	}


	public function stringNull(string $name): ?string
	{
		return isset($this->data[$name]) ? $this->string($name) : null;
	}


	public function string(string $name): string
	{
		array_key_exists($name, $this->data) || throw InvalidTypeException::invalidString($name);

		return Strings::from($this->data[$name]);
	}


	public function float(string $name): float
	{
		return Floats::fromString($this->data[$name] ?? '');
	}


	public function floatNull(string $name): ?float
	{
		return isset($this->data[$name]) ? $this->float($name) : null;
	}


	public function int(string $name): int
	{
		if (isset($this->data[$name]) === false) {
			throw InvalidTypeException::invalidFloat($name);
		}

		return Integer::from($this->data[$name]);
	}


	public function intNull(string $name): ?int
	{
		return isset($this->data[$name]) ? $this->int($name) : null;
	}


	public function bool(string|float|int $name): bool
	{
		if (isset($this->data[$name]) === false) {
			return false;
		}

		return Bools::from($this->data[$name]);
	}


	/**
	 * @return array<string>
	 */
	public function array(string $name): array
	{
		$value = $this->data[$name] ?? null;
		if (is_array($value) === false) {
			throw InvalidTypeException::invalidArray($name);
		}

		return $value;
	}


	/**
	 * @return array<string>|null
	 */
	public function arrayNull(string $name): ?array
	{
		return isset($this->data[$name]) ? $this->array($name) : null;
	}

}
