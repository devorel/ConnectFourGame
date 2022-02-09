<?php

class ConnectFour
{
    private $board = [];
    private $rows = 7;
    private $columns = 6;
    private $current_player = 0;
    private $idWinner = 0;
    private $_isEnd = 0;

    public function createNewGame()
    {
        $this->board = [];
        $this->idWinner = 0;
        $this->_isEnd = 0;
        $this->current_player = rand(1, 2);

    }

    public function draw()
    {
        $bord = '';

        if ($this->isEnd()) {
            if ($this->isWinner()) {
                $bord .= " Player {$this->idWinner} is the winner \n\n";
            } else {
                $bord .= "Game over , without any winner\n\n";
            }

        }
        for ($c = $this->columns - 1; $c > -1; $c--) {
            for ($r = 0; $r < $this->rows; $r++) {
                $bord .= $this->getValueBord($r, $c) . '|';
            }
            $bord .= "\n";
        }
        return $bord;


    }

    public function getCurrentPlayer()
    {
        return $this->current_player;
    }

    public function getGame()
    {
        return ['game' => ['bord' => $this->board, 'rows' => $this->rows, 'columns' => $this->columns, 'current_player' => $this->current_player, 'isEnd' => $this->_isEnd, 'isWinner' => $this->idWinner]];
    }

    public function push($x)
    {
        if ($this->isEnd()) {
            return false;
        }
        if ($this->isWinner()) {
            return false;
        }
        if (empty($this->board[$x])) {
            $this->board[$x] = []; //init
        }

        if ($this->set($x, count($this->board[$x]))) {
            if ($this->checkWinner()) {
                return false;

            }
            if ($this->checkEnd()) {
                return false;
            }
            $this->togglePlayer();
            return true;  //continue the game
        }
        return false;  //error
    }

    private function set($x, $y)
    {
        if ($x < 0 || $y < 0 || $x >= $this->rows || $y >= $this->columns) {
            return false;   //error
        }

        if (!empty($this->board[$x][$y])) {

            return false; //error
        }
        $this->board[$x][$y] = $this->current_player;
        return true;
    }

    private function togglePlayer()
    {
        if ($this->current_player == 1) {
            $this->current_player = 2;
        } else {
            $this->current_player = 1;
        }

    }

    public function isWinner()
    {
        return $this->idWinner;
    }

    public function isEnd()
    {
        return $this->_isEnd;
    }

    private function checkWinner()
    {
        // vertical
        for ($c = 0; $c < count($this->board); $c++) {
            if (!empty($this->board[$c])) {
                $line = implode($this->board[$c]);
                if (strpos($line, "1111") !== false) {
                    $this->_isEnd = true;
                    $this->idWinner = 1;
                    return $this->idWinner;
                }
                if (strpos($line, "2222") !== false) {
                    $this->_isEnd = true;
                    $this->idWinner = 2;
                    return $this->idWinner;
                }
            }
        }

        // horizontal
        for ($c = 0; $c < $this->columns; $c++) {
            $line = '';
            for ($r = 0; $r < $this->rows; $r++) {
                $line .= $this->getValueBord($r, $c);
            }
            if (strpos($line, "1111") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 1;
                return $this->idWinner;
            }
            if (strpos($line, "2222") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 2;
                return $this->idWinner;
            }
        }

        // diagonally
        for ($c = 0; $c < $this->columns - 2; $c++) {
            $line = $this->zigzig($c, 0, 1, 1);
            if (strpos($line, "1111") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 1;
                return $this->idWinner;
            }
            if (strpos($line, "2222") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 2;
                return $this->idWinner;
            }
        }
        for ($r = 1; $r < $this->rows - 4; $r++) {
            $line = $this->zigzig(0, $r, 1, 1);
            if (strpos($line, "1111") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 1;
                return $this->idWinner;
            }
            if (strpos($line, "2222") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 2;
                return $this->idWinner;
            }
        }
        for ($c = 3; $c <= $this->columns; $c++) {
            $line = $this->zigzig($c, 0, -1, 1);
            if (strpos($line, "1111") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 1;
                return $this->idWinner;
            }
            if (strpos($line, "2222") !== false) {
                $this->_isEnd = true;
                $this->idWinner = 2;
                return $this->idWinner;
            }
        }
        for ($r = 1; $r < $this->rows - 4; $r++) {
            for ($c = 3; $c <= $this->columns; $c++) {
                $line = $this->zigzig($c, $r, -1, 1);
                if (strpos($line, "1111") !== false) {
                    $this->_isEnd = true;
                    $this->idWinner = 1;
                    return $this->idWinner;
                }
                if (strpos($line, "2222") !== false) {
                    $this->_isEnd = true;
                    $this->idWinner = 2;
                    return $this->idWinner;
                }
            }
        }


        return $this->idWinner;
    }

    private function zigzig($x, $y, $vx = 1, $vy = 1)
    {
        if ($x < 0 || $y < 0 || $x > $this->rows || $y > $this->columns) {
            return '';
        }
        return $this->getValueBord($x, $y) . $this->zigzig($x + $vx, $y + $vy, $vx, $vy);

    }

    private function getValueBord($x, $y)
    {
        if (empty($this->board[$x])) {
            return '_';
        }
        if (empty($this->board[$x][$y])) {
            return '_';
        }
        return $this->board[$x][$y];
    }

    private function checkEnd()
    {
        $sum = 0;
        foreach ($this->board as $item) {
            $sum += count((array)$item);
        }
        if ($sum == $this->columns * $this->rows) {
            $this->_isEnd = true;
            return true;
        }
        return false;
    }
}