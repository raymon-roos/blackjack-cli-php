<?php

declare(strict_types=1);

use App\Rank;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class RankTest extends MockeryTestCase
{
	public function testValuesAreCorrect()
	{
		foreach (Rank::cases() as $rank) {
			$totalValue = ($totalValue ??= 0) + $rank->getWorth();
		}

		$this->assertEquals(95, $totalValue);
	}
}
