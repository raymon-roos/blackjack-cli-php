<?php

declare(strict_types=1);

class BetterCard
{
	private Suit $suit;
	private Value $value;

	public function __construct(
		string|Suit $suit,
		int|string|Value $value
	) {
		$this->suit = match (gettype($suit)) {
			'string' => Suit::fromString($suit),
			'object' => $suit
		};

		$this->value = match (gettype($value)) {
			'string', 'integer' => Value::from("$value"),
			'object' => $value
		};
	}

	public function show(): string
	{
		return "{$this->suit->value} {$this->value->value}";
	}
}
