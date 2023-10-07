<?php

declare(strict_types=1);

namespace Tests;

use App\EndState;
use InvalidArgumentException;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class EndStateTest extends MockeryTestCase
{
	public function testCanMakeEndStateFromScores(): void
	{
		$this->assertEquals(EndState::busted, EndState::tryFromHandScore(22, 3));
		$this->assertEquals(EndState::five_card_charlie, EndState::tryFromHandScore(20, 5));
		$this->assertEquals(EndState::twenty_one, EndState::tryFromHandScore(21, 3));
		$this->assertEquals(EndState::blackjack, EndState::tryFromHandScore(21, 2));
		$this->assertEquals(null, EndState::tryFromHandScore(20, 2));
	}

	public function testCanMakeEndStateFromString(): void
	{
		$this->assertEquals(EndState::busted, EndState::fromString('busted'));
		$this->assertEquals(EndState::five_card_charlie, EndState::fromString('five-card-charlie'));
		$this->assertEquals(EndState::twenty_one, EndState::fromString('twenty-ony'));
		$this->assertEquals(EndState::blackjack, EndState::fromString('blackjack'));
		$this->assertEquals(EndState::folded, EndState::fromString('folded'));
	}

	public function testThrowsOnInvalidArgument(): void
	{
		$this->expectExceptionObject(
			new InvalidArgumentException('test is not a valid end state')
		);

		EndState::fromString('test');
	}
}
