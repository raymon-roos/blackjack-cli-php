<?php

declare(strict_types=1);

namespace App;

class Player
{
	private array $hand = [];
	private int $score = 0;
	private ?EndState $state;
	private bool $isFinished = false;

	public function __construct(private string $name)
	{
	}

	public function getName(): string
	{
		return $this->name;
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

	public function fold(): void
	{
		$this->state = EndState::folded;
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
