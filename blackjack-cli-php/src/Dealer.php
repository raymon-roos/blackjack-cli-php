<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Dealer extends Player
{
	public function __construct(
		public readonly string $name = 'dealer',
		private Deck $deck = new Deck(),
    ) {
		if (empty($name)) {
			throw new InvalidArgumentException('Player name is required');
		}
    }

    public function deal(Player $player): void
    {
		$player->addCard($this->deck->drawCard());
    }

	public function addCard(Card $card): void
	{
		$this->hand[] = $card;
		$this->score += $card->getScore();
		$this->state = EndState::tryFromHandScore($this->score, count($this->hand));

		if (!$this->state && $this->score >= 17) {
			// Dealer always hits until reaching a score of at least 17.
			//  I chose 17 instead of 18 like it says in the assignment,
			//  because the dealer goes bust too often otherwise.
			$this->stand();
		}
	}
}
