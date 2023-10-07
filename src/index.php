<?php

declare(strict_types=1);

namespace App;

require_once('vendor/autoload.php');

($game = new Blackjack())
	->playGame();
