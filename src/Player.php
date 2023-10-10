<?php

declare(strict_types=1);

namespace App;

class Player
{
	private array $hand = [];
	private int $score = 0;
	private ?EndState $state;
	private bool $isFinished = false;

	public function __construct(public readonly string $name)
	{
	}

	public function addCard(Card $card): void
	{
		$this->hand[] = $card;
		$this->score += $card->getScore();
		$this->state = EndState::tryFromHandScore($this->score, count($this->hand));
		$this->isFinished = !is_null($this->state);
	}

	public function showHand(): string
	{
		$output = "{$this->name} has";

		foreach ($this->hand as $card) {
			$output = "$output {$card->show()}";
		}

		return "$output ({$this->score})";
	}

	public function getHandScore(): int
	{
		return $this->score;
	}

	public function stand(): void
	{
		$this->state = EndState::stands;
	}

	public function showState(): ?string
	{
		if (!is_null($this->state)) {
			return "{$this->name} {$this->state->getFormattedState()}";
		}

		return null;
	}

	public function isFinished(): bool
	{
		return $this->isFinished;
	}
}
