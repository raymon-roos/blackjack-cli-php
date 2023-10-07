<?php

declare(strict_types=1);

namespace Tests;

use App\Player;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class PlayerTest extends MockeryTestCase
{
	private function getPlayerWith3Quens()
	{
		$player = new Player('Ada Lovelace');

		for ($i = 0; $i < 3; $i++) {
			$mockCard = Mockery::mock('App\Card');
			$mockCard->shouldReceive([
				'show' => '♥ Q',
				'getScore' => 10,
			]);

			$player->addCard($mockCard);
		}

		return $player;
	}

	public function testCanCalculateHandScore(): void
	{
		$player = $this->getPlayerWith3Quens();

		$this->assertEquals(30, $player->getHandScore(),);
	}

	public function testCanReceiveAndShowCards(): void
	{
		$player = $this->getPlayerWith3Quens();

		$this->assertEquals(
			'Ada Lovelace has ♥ Q ♥ Q ♥ Q (30)',
			$player->showHand()
		);
	}

	public function testCanFold(): void
	{
		$player = new Player('Ada Lovelace');
		$player->fold();

		$this->assertEquals('folded', $player->getState());
	}

	public function testHasName(): void
	{
		$player = new Player('Ada Lovelace');

		$this->assertEquals('Ada Lovelace', $player->getName());
	}
}
