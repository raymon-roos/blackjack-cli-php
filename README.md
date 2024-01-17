## This is a simplified version of Blackjack, written in PHP using OOP

### Why does this exist

Because this was an (admittedly trivial) school assignment about basic object-oriented
programming, and I put some effort into it exploring cool PHP features like backed enums
and generators. I also used it as an opportunity to practice writing unit tests. Now I'm
using to show off that I indeed now how to program PHP OOP style.

### What it does

Play blackjack against the computer.

You can add up to 7 named players, which each play against a virtual dealer. This
implementation has no notion of multiplayer however, so all the players' actions must be
entered into the same game instance. The game could be played by a single player, playing
with one to seven hands simultaneously, though they will still have to enter 7 names.

#### Features it does have

- Adding up to 7 players.
- Players take turns drawing cards (hitting or standing).
- Player are presented their score at the end of the game.

#### Features it doesn't have

- Multiplayer over a network
- Placing bets
- Placing “insurance” bets
- Splitting hands
- Surrendering
- Ace counting as either 1 or 11

### How to use it

Run `php ./src/index.php` from the root of this project, and follow the on-screen
instructions. 

### Design considerations 

I used some obvious classes to model concrete entities that are part of any game of
blackjack, such as cards, a deck, players, a dealer, and an overarching game class.

Additionally, I chose to employ string-backed enums to represent a card's suit and rank,
and a player's end state. This was well-suited (pun intended), as the sets of valid suits,
ranks, and end states are closed, meaning they will not change, and we can cover all their
possible values. 

Granted, most of their functionality could be achieved by simply adding some match
statements to the various classes that use these enums. But I like that moving such
validation logic into a factory method on the enum removes the noise of validation from
those classes. 

Furthermore, it's nice being able to type-hint the enum anywhere it's needed, and knowing
that any value that's passed in is already validated, or it could not be an instance of
that enum. Contrast that to passing around plain strings, and any method would only have
`string` as a type hint, allowing anyone to pass in just any string. Now you either have
to validate that string everywhere you use it, or accept that a faulty string might crash
your program at runtime.

Having enums (which are much like regular classes in many ways) for encapsulating valid
values, also makes it convenient to write tests for them, lightening the testing required
for the classes that use them. In using instances of self-contained, tested classes to
model values, we make invalid states unpresentable.
