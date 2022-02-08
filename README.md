## Connect Four

Connect Four is a game in which two players drop discs into a 7x6 board. The pieces fall straight
down, occupying the lowest available space within the column.
The first player to get four in a row (either vertically, horizontally, or diagonally) wins.

## API

```php 
require_once('ConnectFour.php');

$game = new ConnectFour();
$game->createNewGame();

//for get the crrent player
$game->getCurrentPlayer()

//for push ball
$game->push($c);
   
//for check if the game done
if ($game->isEnd()) {
       
}

//for check if the game done and get the winner
if ($game->isWinner()) {
       
}

//for get the bord and data
$game->getGame();

``` 
### Testing

```bash
php terminal.php
```

## License

MIT License.