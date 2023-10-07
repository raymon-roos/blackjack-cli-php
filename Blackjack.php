<?php

declare(strict_types=1);

namespace App;

use InvalidArgumentException;

class Blackjack
{
	/**
	 * @var Player[] $players
	 */
	private array $players;

	/**
	 * @param Deck $deck
	 * @param Player[] $players
	 */
	public function __construct(
		private Deck $deck = new Deck(),
		?array $players = null,
		private UserPrompter $userPrompter = new UserPrompter(),
	) {
		$this->players = $players ?? $this->addPlayers();

		if (empty($this->players)) {
			throw new InvalidArgumentException('No players given');
		}
	}

	private function addPlayers(): ?array
	{
		echo 'Welcome!' . PHP_EOL;

		$playerNames = $this->userPrompter->promptForPlayerNames();

		return array_map(
			fn (string $playerName) => new Player(trim($playerName)),
			$playerNames
		);
	}

	public function playGame(): void
	{
		$this->dealFirstHand();

		foreach ($this->players as $player) {
			if (!$player->isFinished()) {
				$this->processPlayerTurn($player);
			}
		}

		$foldedPlayers = array_filter(
			$this->players,
			fn (Player $player) => $player->showState() === 'folded'
		);

		// If more than one player folded, find
		// the player with a score closest to 21
		if (count($foldedPlayers) >= 2) {
			$this->processFoldedPlayers($foldedPlayers);
		}
	}

	private function dealFirstHand(): void
	{
		foreach ($this->players as $player) {
			$player->addCard($this->deck->drawCard());
			$player->addCard($this->deck->drawCard());
			echo $player->showHand() . PHP_EOL;
			echo PHP_EOL . $player->showState() . PHP_EOL;
		}
	}

	private function processPlayerTurn(Player $player): void
	{
		echo PHP_EOL . "Your turn {$player->getName()}" . PHP_EOL;
		echo $player->showHand() . PHP_EOL;

		while (!$player->isFinished()) {
			if (!$this->userPrompter->promptForPlayerToDrawCard()) {
				$player->fold();
				echo $player->showHand() . PHP_EOL;
				break;
			}

			$player->addCard($this->deck->drawCard());
			echo $player->showHand() . PHP_EOL;
		}

		echo PHP_EOL . $player->showState() . PHP_EOL;
	}

	private function processFoldedPlayers(array $players): void
	{
		foreach ($players as $player) {
			$topPlayer ??= $player;
			if ($player->getHandScore() > $topPlayer->getHandScore()) {
				$topPlayer = $player;
			}
		}

		echo <<<OUTPUT

		Of all players that folded, {$topPlayer->getName()} got closest to 21,
		{$topPlayer->showHand()}
		
		OUTPUT;
	}
}
