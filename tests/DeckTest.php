<?php

declare(strict_types=1);

namespace Tests;

use App\Card;
use App\Deck;
use App\Suit;
use App\Value;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class DeckTest extends MockeryTestCase
{
	public function testThrowsAfter52CardsDealt(): void
	{
		$this->expectException('RangeException');

		$deck = new Deck();

		while (true) {
			$cards[] = $deck->drawCard();
		}

		$this->assertSame(
			52,
			count($cards)
		);
	}

	public function testDeckHasUniqueCardsOnly(): void
	{
		$deck = new Deck();

		$cards = [];
		for ($i = 0; $i <= 51; $i++) {
			$nextCard = $deck->drawCard();

			foreach ($cards as $previousCard) {
				if ($previousCard == $nextCard) {
					$this->fail('Cards are not unique');
				}
			}

			$cards[] = $nextCard;
		};

		$this->assertSame(
			52,
			count($cards)
		);
	}
}
