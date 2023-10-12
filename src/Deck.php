<?php

declare(strict_types=1);

namespace App;

use Generator;
use RangeException;

class Deck
{
	private readonly Generator $cards;

	public function __construct()
   	{
		$this->cards = $this->generateCards();
	}

	private function generateCards(): Generator
	{
		$suits = Suit::cases();
		$ranks = Rank::cases();

		for ($i = 0; $i < 8; $i++) {
            shuffle($suits);
            shuffle($ranks);

            foreach ($suits as $suit) {
                foreach ($ranks as $rank) {
                    yield new Card($suit, $rank);
                }
            } 
		}
	}

	public function drawCard(): Card
   	{
		$card = $this->cards->current();
		$this->cards->next();

		return $card 
			?? throw new RangeException('All out of cards');
	}
}
