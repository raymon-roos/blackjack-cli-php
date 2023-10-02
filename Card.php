<?php

declare(strict_types=1);

class Card
{
	public string $suit;
	public int|string $value;

	public function show(): string
	{
		return "{$this->suit} {$this->value}";
	}
}
