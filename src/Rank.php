<?php

declare(strict_types=1);

namespace App;

enum Rank: string
{
	case two   = '2';
	case three = '3';
	case four  = '4';
	case five  = '5';
	case six   = '6';
	case seven = '7';
	case eight = '8';
	case nine  = '9';
	case ten   = '10';
	case jack  = 'J';
	case queen = 'Q';
	case king  = 'K';
	case ace   = 'A';

	public function getWorth(): int
	{
		return match ($this) {
			self::ace => 11,
			self::jack, self::queen, self::king => 10,
			default => (int) $this->value,
		};
	}
}
