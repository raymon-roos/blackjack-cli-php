<?php

declare(strict_types=1);

namespace Tests;

use App\Player;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class PlayerTest extends MockeryTestCase
{
	public function testCanReceiveAndShowCards(): void
	{
		$mockCard = Mockery::mock('App\Card');
		$mockCard->shouldReceive('show')
			->andReturn('♥ Q');

		$mockDeck = Mockery::mock('App\Deck');
		$mockDeck->shouldReceive('drawCard')
			->andReturn($mockCard);

		$player = new Player('test');

		$player->addCard($mockDeck->drawCard());

		$this->assertEquals(
			'test has ♥ Q',
			$player->showHand(),
		);
	}
}
