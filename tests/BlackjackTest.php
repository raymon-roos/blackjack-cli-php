<?php

declare(strict_types=1);

namespace Tests;

use App\Blackjack;
use App\Card;
use App\Rank;
use App\Suit;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class BlackjackTest extends MockeryTestCase
{
	public function testThrowsWhenMissingPlayers(): void
	{
		$this->expectExceptionObject(
			new InvalidArgumentException('No players given')
		);

		new Blackjack(players: []);
	}

	public function testPlayersCanStand(): void
	{
		$mockPrompter = Mockery::mock('App\UserPrompter');
		$mockPrompter->shouldReceive([
			'promptForPlayerToDrawCard' => false,
		]);

		$mockPlayer = Mockery::mock('App\Player');
		$mockPlayer->shouldReceive([
			'addCard' => null,
			'stand' => null,
			'isFinished' => false,
			'showState'  => 'Katherine Johnson stands',
			'showHand' => 'Katherine Johnson has ♥ 9001',
		]);

		(new Blackjack(userPrompter: $mockPrompter, players: [$mockPlayer]))
			->playGame();

		$this->expectOutputRegex('/.*Welcome!.*/');
		$this->expectOutputRegex('/.*Katherine Johnson has ♥ 9001.*/');
		$this->expectOutputRegex('/.*Your turn Katherine Johnson.*/');
		$this->expectOutputRegex('/.*Katherine Johnson stands.*/');
	}

	public function testPlayersCanGetBusted(): void
	{
		$mockDeck = Mockery::mock('App\Deck');
		$mockDeck->shouldReceive([
			'drawCard' => new Card(Suit::hearts, Rank::queen)
		]);

		$mockPrompter = Mockery::mock('App\UserPrompter');
		$mockPrompter->shouldReceive([
			'promptForPlayerNames' => ['Mary Kenneth Keller'],
			'promptForPlayerToDrawCard' => true,
		]);

		(new Blackjack($mockDeck, userPrompter: $mockPrompter))
			->playGame();

		$this->expectOutputRegex('/.*Welcome!.*/');
		$this->expectOutputRegex('/.*Your turn Mary Kenneth Keller.*/');
		$this->expectOutputRegex('/.*Mary Kenneth Keller has ♥ 10 ♥ 10 \(20\).*/');
		$this->expectOutputRegex('/.*Mary Kenneth Keller has ♥ 10 ♥ 10 ♥ 10 \(30\).*/');
		$this->expectOutputRegex('/.*Mary Kenneth Keller is Busted!.*/');
	}

	public function testPlayersCanGetBlackjack(): void
	{
		$mockDeck = Mockery::mock('App\Deck');
		$mockDeck->shouldReceive('drawCard')
			->andReturn(
				new Card(Suit::hearts, Rank::ace),
				new Card(Suit::hearts, Rank::queen),
			);

		$mockPrompter = Mockery::mock('App\UserPrompter');
		$mockPrompter->shouldReceive([
			'promptForPlayerNames' => ['Joy Buolamwini'],
		]);

		(new Blackjack($mockDeck, userPrompter: $mockPrompter))
			->playGame();

		$this->expectOutputRegex('/.*Welcome!.*/');
		$this->expectOutputRegex('/.*Your turn Joy Buolamwini.*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has ♥ A ♥ Q \(21\).*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has Blackjack!.*/');
	}

	public function testPlayersCanGetTwentyOne(): void
	{
		$mockDeck = Mockery::mock('App\Deck');
		$mockDeck->shouldReceive('drawCard')
			->andReturn(
				new Card(Suit::hearts, Rank::ace),
				new Card(Suit::hearts, Rank::four),
				new Card(Suit::hearts, Rank::six),
			);

		$mockPrompter = Mockery::mock('App\UserPrompter');
		$mockPrompter->shouldReceive([
			'promptForPlayerNames' => ['Joy Buolamwini'],
			'promptForPlayerToDrawCard' => true,
		]);

		(new Blackjack($mockDeck, userPrompter: $mockPrompter))
			->playGame();

		$this->expectOutputRegex('/.*Welcome!.*/');
		$this->expectOutputRegex('/.*Your turn Joy Buolamwini.*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has ♥ A ♥ 4 ♥ 6 \(21\).*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has Twenty-One!.*/');
	}

	public function testPlayersCanGetFiveCardCharlie(): void
	{
		$mockDeck = Mockery::mock('App\Deck');
		$mockDeck->shouldReceive('drawCard')
			->andReturn(
				new Card(Suit::hearts, Rank::two),
				new Card(Suit::hearts, Rank::three),
				new Card(Suit::hearts, Rank::four),
				new Card(Suit::hearts, Rank::five),
				new Card(Suit::hearts, Rank::six),
			);

		$mockPrompter = Mockery::mock('App\UserPrompter');
		$mockPrompter->shouldReceive([
			'promptForPlayerNames' => ['Joy Buolamwini'],
			'promptForPlayerToDrawCard' => true,
		]);

		(new Blackjack($mockDeck, userPrompter: $mockPrompter))
			->playGame();

		$this->expectOutputRegex('/.*Welcome!.*/');
		$this->expectOutputRegex('/.*Your turn Joy Buolamwini.*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has ♥ 2 ♥ 3 ♥ 4 ♥ 5 ♥ 6 \(21\).*/');
		$this->expectOutputRegex('/.*Joy Buolamwini has Five-Card-Charlie!.*/');
	}
}
