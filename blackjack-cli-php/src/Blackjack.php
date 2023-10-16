<?php

declare(strict_types=1);

namespace App;

class Blackjack
{
	/**
	 * @var Player[] $players
	 */
	private array $players;

	/**
	 * @param null|Player[] $players
	 */
    public function __construct(
        ?array $players = null,
        private Dealer $dealer = new Dealer(),
        private UserPrompter $userPrompter = new UserPrompter(),
    ) {
		$players = array_values(array_filter(
            $players ??= $this->addPlayers(),
            fn ($input) => $input instanceof Player
        ));

        if (empty($players)) {
			throw new \InvalidArgumentException('No players given');
        }

		$this->players = [$this->dealer, ...$players];
    }

	private function addPlayers(): ?array
	{
		echo 'Welcome to blackjack!' . PHP_EOL
		. 'Up to 7 players are allowed to participate' . PHP_EOL;

        while (
            count($players ??= []) < 7
			&& $playerName = $this->userPrompter->promptForPlayerName()
        ) {
			try {
                $players[] = new Player(trim($playerName));
            } catch (\InvalidArgumentException) {
				echo 'A name is required, please try again' . PHP_EOL;
            }
        }

		return $players;
	}

	public function playGame(): void
	{
		echo 'Starting the game now' . PHP_EOL;

        $this->dealFirstHand();

		while (!$this->dealer->isFinished()) {
            foreach ($this->players as $player) {
				if ($player->isFinished()) {
					continue;
				}

				$this->processPlayerTurn($player);

				if ($this->dealer->getState() === EndState::busted) {
					break;
				}
            }
        }

		$this->showScores();
    }

	private function dealFirstHand(): void
	{
		foreach ($this->players as $player) {
			$this->dealer->deal($player);
			$this->dealer->deal($player);
			echo $player->showHand() . PHP_EOL;
		}
	}

	private function processPlayerTurn(Player $player): void
	{
		echo PHP_EOL . "Your turn {$player->name}" . PHP_EOL;
		echo 'Currently, ' . $player->showHand() . PHP_EOL;

		match (true) {
			$player instanceof Dealer,
			$this->userPrompter->promptForPlayerToDrawCard() => $this->dealer->deal($player),
			default => $player->stand()
		};

		echo $player->showHand() . PHP_EOL;
	}

	private function showScores(): void
	{
		echo PHP_EOL . 'Final scores:' . PHP_EOL;

		$dealer = array_shift($this->players);

		if ($dealer->getState() === EndState::busted) {
			echo 'Dealer lost, all players win!' . PHP_EOL;
			return;
        }

		foreach ($this->players as $player) {
			if ($player->isFinished()) {
                echo $player->showState() . PHP_EOL;
                continue;
			}

			$pointsDifference = $dealer->getHandScore() - $player->getHandScore();

			echo match (true) {
				$pointsDifference > 0 => "$player->name lost by by $pointsDifference points",
				$pointsDifference === 0 => "$player->name is at a standoff",
				$pointsDifference < 0 => "$player->name won by by " . abs($pointsDifference) . ' points',
			} . PHP_EOL;
		}
	}
}
