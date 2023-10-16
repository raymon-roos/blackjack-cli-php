<?php

declare(strict_types=1);

namespace Tests;

use App\Deck;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\Attributes\Depends;
use RangeException;

final class DeckTest extends MockeryTestCase
{
	public function testThrowsOnEmptyDeck(): int
	{
		$deck = new Deck();

		$this->expectExceptionObject(
			new RangeException('All out of cards')
		);

		$count = 0;
        while ($deck->drawCard()) {
            $count++;
        }

		return $count;
	}

	#[Depends('testThrowsOnEmptyDeck')]
	public function testHas8DecksWorthOfCards(?int $count): void
	{
		$this->assertSame(8 * 52, $count ?? $this->testThrowsOnEmptyDeck());
	}
}
