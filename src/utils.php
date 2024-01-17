<?php

declare(strict_types=1);

/**
 * @return never
 */
function dd(...$args): void
{
    $print = function ($arg): void {
        if (PHP_SAPI === 'cli') {
            var_dump($arg);
            return;
        }

        echo '<pre style="font-size: 13pt; background-color: gray; color: darkblue;">';
        var_dump($arg);
        echo '</pre>';
    };

    array_walk($args, $print);

    exit();
}
