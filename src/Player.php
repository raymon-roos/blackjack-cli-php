<?php

declare(strict_types=1);

namespace App;

class Player
{
	private array $hand = [];
	private int $score = 0;

	public function __construct(private string $name)
	{
	}

	public function addCard(Card $card): void
	{
		$this->hand[] = $card;
		$this->score += $card->getScore();
	}

	public function showHand(): string
	{
		$output = "{$this->name} has";

		foreach ($this->hand as $card) {
			$output = "$output {$card->show()}";
		}

		return $output;
	}

	public function getHandScore(): int
	{
		return $this->score;
	}
}
