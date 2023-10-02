<?php

declare(strict_types=1);

class Deck
{
	private array $cards = [];

	public function __construct()
	{
		foreach (Suit::cases() as $suit) {
			foreach (Value::cases() as $value) {
				$this->cards[] = new Card($suit, $value);
			}
		}
	}

	public function drawCard(): Card
	{
		if (empty($this->cards)) {
			throw new Exception('All out of cards');
		}

		$index = array_rand($this->cards);
		$card = $this->cards[$index];
		unset($this->cards[$index]);

		return $card;
	}
}
