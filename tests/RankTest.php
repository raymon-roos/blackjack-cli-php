<?php

declare(strict_types=1);

use App\Rank;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class RankTest extends MockeryTestCase
{
	public function testValuesAreCorrect()
	{
		$this->assertEquals(
			95,
			array_reduce(
				Rank::cases(),
				fn (?int $carry, Rank $item, int $initial = 0): int => $carry += $item->getWorth()
			)
		);
	}
}
