<?php

declare(strict_types=1);

/**
 * @return never
 */
function dd(...$args): void
{
	var_dump(...$args);
	exit();
}
