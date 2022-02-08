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
        $res = [];
        //index for horizontal
        for ($r = 0; $r < count($this->board); $r++) {
            if (!empty($this->board[$r])) {
                for ($c = 0; $c < count($this->board[$r]) - 4; $c++) {
                    $res[$this->getValueBord($r, $c) . $this->getValueBord($r, $c + 1) . $this->getValueBord($r, $c + 2) . $this->getValueBord($r, $c + 3)] = 1;
                }
            }
        }
        //index for vertical
        for ($r = 0; $r < count($this->board) - 4; $r++) {
            if (!empty($this->board[$r])) {
                for ($c = 0; $c < count($this->board[$r]); $c++) {
                    $res[$this->getValueBord($r, $c) . $this->getValueBord($r + 1, $c) . $this->getValueBord($r + 2, $c) . $this->getValueBord($r + 3, $c)] = 1;
                }
            }
        }

        //index for diagonally
        for ($r = 0; $r < $this->rows; $r++) {
            $vl = 0;
            $vr = $r;
            $vlm = 0;
            $vrm = $this->columns - $r - 1;
            for ($c = 0; $c < $this->columns; $c++) {
                $res[$this->getValueBord($vl++, $vr++) . $this->getValueBord($vl++, $vr++) . $this->getValueBord($vl++, $vr++) . $this->getValueBord($vl++, $vr++)] = 1;
                $res[$this->getValueBord($vlm++, $vrm--) . $this->getValueBord($vlm++, $vrm--) . $this->getValueBord($vlm++, $vrm--) . $this->getValueBord($vlm++, $vrm--)] = 1;
            }

        }

        if (!empty($res['1111'])) {
            $this->_isEnd = true;
            $this->idWinner = 1;
        }
        if (!empty($res['2222'])) {
            $this->_isEnd = true;
            $this->idWinner = 2;
        }

        return $this->idWinner;
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