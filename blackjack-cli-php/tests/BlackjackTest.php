<?php

declare(strict_types=1);

namespace Tests;

use App\Blackjack;
use App\Dealer;
use App\EndState;
use App\Player;
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

        $player = new Player('Katherine Johnson');

        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive([
            'getScore' => 7,
            'show' => '♥ 7',
        ]);

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $dealer = new Dealer(deck: $mockDeck);

        $game = new Blackjack([$player], $dealer, $mockPrompter);
        $game->playGame();

        $this->expectOutputRegex('/.*Welcome!.*/');
        $this->expectOutputRegex('/.*Katherine Johnson has ♥ 9001.*/');
        $this->expectOutputRegex('/.*Your turn Katherine Johnson.*/');
        $this->expectOutputRegex('/.*Katherine Johnson stands.*/');
    }

    public function testDealerDrawsUntilAtLeast17Points(): void
       {
        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive('getScore')
            ->andReturn(10, 7);
        $mockCard->shouldReceive('show')
            ->andReturn('♥ 10', '♥ 7');

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $player = new Player('Bletchley Park');

        $mockPrompter = Mockery::mock('App\UserPrompter');
        $mockPrompter->shouldReceive(['promptForPlayerToDrawCard' => true]);

        $dealer = new Dealer(deck: $mockDeck);

        $game = new Blackjack([$player], $dealer, $mockPrompter);
        $game->playGame();

        $this->assertEquals(EndState::stands, $dealer->getState());
        $this->expectOutputRegex('/.*Welcome to blackjack!.*/');
        $this->expectOutputRegex('/.*Starting the game now.*/');
        $this->expectOutputRegex('/.*Your turn dealer.*/');
        $this->expectOutputRegex('/.*dealer has ♥ 10 ♥ 7 (17).*/');
        $this->expectOutputRegex('/.*dealer stands.*/');
    }

    public function testPlayersCanGetBusted(): void
    {
        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive('getScore')
            ->andReturn(5, 11);
        $mockCard->shouldReceive('show')
            ->andReturn('♥ 5', '♥ A');

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive([
            'drawCard' => $mockCard,
        ]);

        $mockPrompter = Mockery::mock('App\UserPrompter');
        $mockPrompter->shouldReceive('promptForPlayerName')
            ->andReturn('Mary Kenneth Keller', '');
        $mockPrompter->shouldReceive('promptForPlayerToDrawCard')
            ->andReturn(true);

        $dealer = new Dealer(deck: $mockDeck);

        $game = new Blackjack(dealer: $dealer, userPrompter: $mockPrompter);
        $game->playGame();

        $this->expectOutputRegex('/\s*Welcome to blackjack!\s*/');
        $this->expectOutputRegex('/\s*Starting the game now\s*/');
        $this->expectOutputRegex('/\s*Your turn dealer\s*/');
        $this->expectOutputRegex('/\s*dealer has ♥ 5 ♥ A \(11\)\s*/');
        $this->expectOutputRegex('/\s*Mary Kenneth Keller has ♥ A ♥ A \(22\)\s*/');
        $this->expectOutputRegex('/\s*Mary Kenneth Keller is Busted!\s*/');
    }

    public function testPlayersCanGetBlackjack(): void
    {
        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive('getScore')
            ->andReturn(5, 11, 10, 11);
        $mockCard->shouldReceive('show')
            ->andReturn('♥ 5', '♥ A', '♥ 10', '♥ A');

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive([
            'drawCard' => $mockCard,
        ]);

        $mockPrompter = Mockery::mock('App\UserPrompter');
        $mockPrompter->shouldReceive('promptForPlayerName')
            ->andReturn('Joy Buolamwini', '');
        $mockPrompter->shouldReceive('promptForPlayerToDrawCard')
            ->andReturn(true);

        $dealer = new Dealer(deck: $mockDeck);

        $game = new Blackjack(dealer: $dealer, userPrompter: $mockPrompter);
        $game->playGame();

        $this->expectOutputRegex('/\s*Welcome to blackjack!\s*/');
        $this->expectOutputRegex('/\s*Starting the game now\s*/');
        $this->expectOutputRegex('/\s*Your turn dealer\s*/');
        $this->expectOutputRegex('/\s*dealer has ♥ 5 ♥ A \(11\)\s*/');
        $this->expectOutputRegex('/.*Your turn Joy Buolamwini.*/');
        $this->expectOutputRegex('/.*Joy Buolamwini has ♥ 10 ♥ A \(21\).*/');
        $this->expectOutputRegex('/.*Joy Buolamwini has Blackjack!.*/');
    }

    public function testGameEndsWhenDealerIsBusted(): void
    {
        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive('getScore')
            ->andReturn(11, 11);
        $mockCard->shouldReceive('show')
            ->andReturn('♥ A', '♥ A');

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive([
            'drawCard' => $mockCard,
        ]);

        $mockPrompter = Mockery::mock('App\UserPrompter');
        $mockPrompter->shouldReceive('promptForPlayerName')
            ->andReturn('Joy Buolamwini', '');
        $mockPrompter->shouldReceive('promptForPlayerToDrawCard')
            ->andReturn(true);

        $dealer = new Dealer(deck: $mockDeck);

        $game = new Blackjack(dealer: $dealer, userPrompter: $mockPrompter);
        $game->playGame();

        $this->expectOutputRegex('/\s*Welcome to blackjack!\s*/');
        $this->expectOutputRegex('/\s*Starting the game now\s*/');
        $this->expectOutputRegex('/\s*Your turn dealer\s*/');
        $this->expectOutputRegex('/\s*dealer has ♥ A ♥ A \(22\) dealer is Busted!\s*/');
        $this->expectOutputRegex('/.*Joy Buolamwini has ♥ A ♥ A \(22\) Joy Buolamwini is Busted!.*/');
        $this->expectOutputRegex('/\s*dealer has ♥ A ♥ A \(22\) dealer is Busted!\s*/');
        $this->expectOutputRegex('/\s*Final scores:\s+Dealer lost, all players win!\s*/');
    }
}
