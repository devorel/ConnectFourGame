<?php
require_once('ConnectFour.php');

$game = new ConnectFour();
$game->createNewGame();

echo "Welcome to the game Connect Four \n";
echo "Press 0 for exit\n\n";
echo $game->draw();

while ($c = (int)readline("Player {$game->getCurrentPlayer()} choose a column: ")) {

    $c -= 1;
    if ($c > -1 && $c < 7) {
        $game->push($c);
    }
    echo $game->draw();

    if ($game->isEnd()) {
        break;
    }
}