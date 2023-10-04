<?php

declare(strict_types=1);

use App\Rank;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class RankTest extends MockeryTestCase
{
	public function testCanAddUpScores(): void
	{
		$this->assertEquals(
			15,
			Rank::four->getWorth() + Rank::ace->getWorth()
		);
	}
}
