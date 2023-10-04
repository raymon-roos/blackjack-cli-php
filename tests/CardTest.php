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
}
