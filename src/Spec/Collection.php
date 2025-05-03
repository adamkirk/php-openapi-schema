<?php

declare(strict_types=1);

namespace OpenApiSchema\Spec;

use stdClass;
use InvalidArgumentException;

/**
 * @template T
 */
abstract class Collection implements Marshallable
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

	abstract protected static function isType(mixed $value): bool;
}
