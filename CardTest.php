<?php

declare(strict_types=1);

use Mockery\Adapter\Phpunit\MockeryTestCase;

final class CardTest extends MockeryTestCase
{
	public function testCardCanShow(): void
	{
		$card = new Card();
		$card->suit = '♠';
		$card->value = 5;

		$this->assertSame('♠ 5', $card->show());
	}
}
