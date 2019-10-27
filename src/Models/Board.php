<?php
/*
 * The Rich Data Model for the Board object.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/

namespace App\Models;

use App\Utils\SymbolUtils;

class Board {

    private $columns;
    private $rows;
    private $grid;

    public function __construct($columns = 5, $rows = 3) {
        $this->columns = $columns;
        $this->rows = $rows;
        $this->grid = array(array());
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getRows() {
        return $this->rows;
    }

    public function getGrid() {
        return $this->grid;
    }

    public function setGrid($grid) {
        $this->grid = $grid;
    }

    /**
     * TO-DO: for a second version, it would be possible to implement this method in
     * a way that would work regardless the Board's dimention, currently, it works only
     * for matrixes with 3 rows and 5 columns.
     *
     * This method is capable of retrieving a specific element from the grid (2d matrix)
     * just by receiving the desired index position. In this way, there is NO NEED to
     * traverse the array looking for the element (board' symbol).
     *
     * Formula:
     * element = arr[(index % 3)][(index / 3)]
     *
     * @param $indexBoard  The board`s position being searched.
     *
     * @return The element from the particular board position.
     */
    public function retrieveSymbol($indexBoard) {
        $row = ($indexBoard % 3);
        $col = intdiv($indexBoard, 3);
        return $this->grid[$row][$col];
    }

    /**
     * It fills the two dimentional gird with ramdom values.
     *
     * @return void
     */
    public function fillRandomly() {
        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->columns; $col++) {
                $this->grid[$row][$col] = SymbolUtils::fetchRandomValue();
            }
        }
    }

    public function printGrid() {
        echo "\n";
        for ($row = 0; $row < count($this->grid); $row++) {
            for ($col = 0; $col < count($this->grid[$row]); $col++) {
                echo $this->grid[$row][$col] . " - ";
            }
            echo "\n";
        }
    }
}
