<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

enum EndState: string
{
	case busted = 'Busted!';
	case five_card_charlie = 'Five-Card-Charlie!';
	case twenty_one = 'Twenty-one!';
	case blackjack = 'Blackjack!';
	case folded = 'folded';

	public static function tryFromHandScore(int $score, int $count): ?self
	{
		return match (true) {
			$score > 21                   => self::busted,
			$score < 21 && $count === 5   => self::five_card_charlie,
			$score === 21 && $count === 2 => self::blackjack,
			$score === 21                 => self::twenty_one,
			default                       => null
		};
	}

	public static function fromString(string $state): ?self
	{
		return match (strtolower(trim($state))) {
			'busted'            => self::busted,
			'five-card-charlie' => self::five_card_charlie,
			'twenty-ony'        => self::twenty_one,
			'blackjack'         => self::blackjack,
			'folded'            => self::folded,
			default             => throw new InvalidArgumentException("$state is not a valid end state")
		};
	}

	public function getFormattedState(): string
	{
		return match ($this) {
			self::busted => 'is ',
			default => 'has ',
		}
			. $this->value;
	}
}
