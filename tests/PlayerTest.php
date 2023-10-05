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
		$mockCard->shouldReceive([
			'show' => '♥ Q',
			'getScore' => 10,
		]);

		$player = new Player('test');

		$player->addCard($mockCard);

		$this->assertEquals(
			'test has ♥ Q',
			$player->showHand(),
		);
	}

	public function testCanCalculateHandScore(): void
	{
		$player = new Player('test');

		$mockCard = Mockery::mock('App\Card');
		$mockCard->shouldReceive('getScore')
			->andReturn(11);
		$player->addCard($mockCard);

		$mockCard = Mockery::mock('App\Card');
		$mockCard->shouldReceive('getScore')
			->andReturn(5);
		$player->addCard($mockCard);

		$this->assertEquals(
			16,
			$player->getHandScore(),
		);
	}

	public function testHasName(): void
	{
		$player = new Player('Ada Lovelace');

		$this->assertEquals(
			'Ada Lovelace',
			$player->getName(),
		);
	}
}
