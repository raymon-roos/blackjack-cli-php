<?php

declare(strict_types=1);

namespace Tests;

use App\Card;
use App\Suit;
use App\Rank;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class CardTest extends MockeryTestCase
{
	public function testCardCanShow(): void
	{
		$card = new Card(Suit::spades, Rank::five);

		$this->assertSame('♠ 5', $card->show());
	}

	public function testCanMakeCardFromPrimitives(): void
	{
		$card = new Card('spades', 5);

		$this->assertSame('♠ 5', $card->show());
	}

	public function testCanAddUpScores(): void
	{
		$aceOfClubs = new Card(Suit::clubs, Rank::ace);
		$queenOfHearts = new Card(Suit::hearts, Rank::queen);

		$this->assertEquals(
			21,
			$aceOfClubs->getScore() + $queenOfHearts->getScore()
		);
	}
}
