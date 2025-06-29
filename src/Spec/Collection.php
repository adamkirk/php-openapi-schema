<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

use Iterator;
use stdClass;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;

/**
 * @template T
 *
 * @implements IteratorAggregate<int, T>
 */
abstract class Collection implements Marshallable, IteratorAggregate
{
	/** @var array<int, T> $items */
	protected array $items;

	public function __construct()
	{
		$this->items = [];
	}

	public function isEmpty(): bool
	{
		return empty($this->items);
	}

	/** @param T $items */
	public function add(mixed ...$items): static
	{
		foreach ($items as $item) {
			if (! static::isType($item)) {
				throw new InvalidArgumentException('incorrect type for ' . static::class);
			}
		}

		$this->items = array_merge($this->items, array_values($items));

		return $this;
	}

	public function toMarshallable(MarshallingContext $ctx): array|stdClass
	{
		return array_map(
			fn($item) => $item instanceof Marshallable ? $item->toMarshallable($ctx) : $item,
			$this->items,
		);
	}

	public function getIterator(): Iterator
	{
		return new ArrayIterator($this->items);
	}

	abstract protected static function isType(mixed $value): bool;
}
