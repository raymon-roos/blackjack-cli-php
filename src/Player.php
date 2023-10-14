<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Player
{
	protected array $hand = [];
	protected int $score = 0;
	protected ?EndState $state = null;

    public function __construct(public readonly string $name)
    {
		if (empty($name)) {
			throw new InvalidArgumentException('Player name is required');
        }
    }

	public function addCard(Card $card): void
	{
		$this->hand[] = $card;
		$this->score += $card->getScore();
		$this->state = EndState::tryFromHandScore($this->score, count($this->hand));
	}

	public function showHand(): string
	{
		$output = "{$this->name} has";
		foreach ($this->hand as $card) {
			$output = "$output {$card->show()}";
		}
		$output = "$output ({$this->score})";

		if ($this->isFinished()) {
			$output = "$output, {$this->showState()}";
		}

		return $output;
	}

	public function getHandScore(): int
	{
		return $this->score;
	}

	public function stand(): void
	{
		$this->state = EndState::stands;
	}

    public function getState(): ?EndState
    {
		return $this->state;
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
		return $this->state instanceof EndState;
	}
}
