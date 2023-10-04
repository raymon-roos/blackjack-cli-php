<?php

declare(strict_types=1);

namespace App;

enum Suit: string
{
	case clubs    = '♣';
	case diamonds = '♦';
	case hearts   = '♥';
	case spades   = '♠';

	public static function fromString(string $suit): self
	{
		return match ($suit) {
			'clubs', 'c', 'C', '♣' => self::clubs,
			'diamonds', 'd', 'D', '♦' => self::diamonds,
			'hearts', 'h', 'H', '♥' => self::hearts,
			'spades', 's', 'S', '♠' => self::spades,
			default => throw new InvalidArgumentException('Invalid argument')
		};
	}
}
