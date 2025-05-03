<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

use stdClass;
use InvalidArgumentException;

/**
 * @template T
 */
abstract class Dictionary implements Marshallable
{
	/**
	 * @var array<string, T> $items
	 */
	protected array $items;

	public function __construct()
	{
		$this->items = [];
	}

	public function isEmpty(): bool
	{
		return empty($this->items);
	}

	/** @param T $item */
	public function add(string $key, mixed $item): static
	{
		if (! static::isType($item)) {
			throw new InvalidArgumentException('incorrect type for ' . static::class);
		}

		$this->items[$key] = $item;
		return $this;
	}

	/**
	 * @param T|null $default
	 *
	 * @return T|null
	 */
	public function get(string $key, mixed $default = null): mixed
	{
		return $this->items[$key] ?? $default;
	}

	public function has(string $key): bool
	{
		return array_key_exists($key, $this->items);
	}

	public function toMarshallable(MarshallingContext $ctx): array|stdClass
	{
		if ($this->isEmpty()) {
			return new stdClass();
		}

		return array_map(
			fn($item) => $item instanceof Marshallable ? $item->toMarshallable($ctx) : $item,
			$this->items,
		);
	}

	abstract protected static function isType(mixed $value): bool;
}
