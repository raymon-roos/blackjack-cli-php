<?php

declare(strict_types=1);

enum Value: string
{
	case ace   = 'A';
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

	public function getWorth(): int
	{
		return match (true) {
			is_numeric($this->value) => (int) $this->value,
			$this->value === 'A' => 1,
			$this->value === 'J' => 11,
			$this->value === 'Q' => 12,
			$this->value === 'K' => 13,
		};
	}
}
