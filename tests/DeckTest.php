<?php

declare(strict_types=1);

namespace Tests;

use App\Deck;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use RangeException;

final class DeckTest extends MockeryTestCase
{
	public function testDeals52UniqueCardsThenThrows(): void
	{
		$deck = new Deck();

		$this->expectExceptionObject(
			new RangeException('All out of cards')
		);

		$cards = [];
		while (true) {
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
