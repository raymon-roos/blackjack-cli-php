<?php

declare(strict_types=1);

use Mockery\Adapter\Phpunit\MockeryTestCase;

final class ValueTest extends MockeryTestCase
{
	public function testCanAddUpScores(): void
	{
		$this->assertEquals(
			Value::four->getWorth() + Value::ace->getWorth(),
			5
		);
	}
}
