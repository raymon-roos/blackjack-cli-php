<?php

declare(strict_types=1);

namespace App;

require_once('vendor/autoload.php');

if (isset($argv[1]) && in_array(trim($argv[1]), ['-s', '--simulate'])) {
    // For manual testing perposes

    // Automatically run through a full game, with seven players numbered one
    // through seven, that will always draw as many cards as possible 

    for ($i = 1; $i < 8; $i++) { 
        $players[] = new Player("$i");
    }

    $fakePrompter = new Class extends UserPrompter {
        public function promptForPlayerToDrawCard(): bool
        {
            return true;
        }
    };
}

($game = new Blackjack($players ?? null, userPrompter: $fakePrompter ?? new UserPrompter()))
    ->playGame();
