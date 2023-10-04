<?php

declare(strict_types=1);

namespace Tests;

use App\Suit;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class SuitTest extends MockeryTestCase
{
	public function testCanMakeSuitFromString(): void
	{
		$this->assertEquals(Suit::fromString('clubs'), Suit::clubs);
		$this->assertEquals(Suit::fromString('d'), Suit::diamonds);
		$this->assertEquals(Suit::fromString('H'), Suit::hearts);
		$this->assertEquals(Suit::fromString('♠'), Suit::spades);
	}
}
