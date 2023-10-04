<?php

declare(strict_types=1);

namespace App;

use RangeException;

class Deck
{
	private array $cards = [];

	public function __construct()
	{
		foreach (Suit::cases() as $suit) {
			foreach (Rank::cases() as $rank) {
				$this->cards[] = new Card($suit, $rank);
			}
		}
	}

	public function drawCard(): Card
	{
		if (empty($this->cards)) {
			throw new RangeException('All out of cards');
		}

		$index = array_rand($this->cards);
		$card = $this->cards[$index];
		unset($this->cards[$index]);

		return $card;
	}
}
