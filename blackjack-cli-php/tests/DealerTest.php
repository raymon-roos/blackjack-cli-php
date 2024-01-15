<?php

declare(strict_types=1);

namespace Tests;

use App\Card;
use App\Dealer;
use App\EndState;
use App\Rank;
use App\Suit;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

final class DealerTest extends MockeryTestCase
{
    public function testIsNamedDealer(): void
    {
        $dealer = new Dealer();

        $this->assertEquals('dealer', $dealer->name);
    }

    public function testCanDeal(): void
    {
        $spyPlayer = Mockery::spy('App\Player');

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive([
            'drawCard' => $card = new Card(Suit::spades, Rank::ace)
        ]);

        $dealer = new Dealer(deck: $mockDeck);

        $dealer->deal($spyPlayer);

        $spyPlayer->shouldHaveReceived('addCard', [$card]);
    }

    public function testDealerStandsAt17Points(): void
       {
        $mockCard = Mockery::mock('App\Card');
        $mockCard->shouldReceive(['getScore' => 17]);

        $mockDeck = Mockery::mock('App\Deck');
        $mockDeck->shouldReceive('drawCard')
            ->andReturn($mockCard);

        $dealer = new Dealer(deck: $mockDeck);

        $dealer->deal($dealer);

        $this->assertEquals(EndState::stands, $dealer->getState());
    }
}
