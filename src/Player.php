<?php

declare(strict_types=1);

namespace App;

class Player
{
	private array $hand = [];

	public function __construct(private string $name)
	{
	}

	public function addCard(Card $card): void
	{
		$this->hand[] = $card;
	}

	public function showHand(): string
	{
		$output = "{$this->name} has";
		array_walk($this->hand, static function (Card $card) use (&$output) {
			$output = "$output {$card->show()}";
		});

		return $output;
	}
}
