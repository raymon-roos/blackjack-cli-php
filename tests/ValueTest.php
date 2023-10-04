<?php

declare(strict_types=1);

use App\Value;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class ValueTest extends MockeryTestCase
{
	public function testCanAddUpScores(): void
	{
		$this->assertEquals(
			5,
			Value::four->getWorth() + Value::ace->getWorth()
		);
	}
}
