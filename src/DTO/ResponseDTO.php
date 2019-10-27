<?php
/*
 * The Data Transfer Object used to display the Game's status into the console.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/
namespace App\DTO;

class ResponseDTO implements \JsonSerializable {

    private $board;
    private $paylines;
    private $betAmount;
    private $total_win;

    public function __construct($board, $paylines, $betAmount, $total_win) {
        $this->board = $board;
        $this->paylines = $paylines;
        $this->betAmount = $betAmount;
        $this->total_win = $total_win;
    }

    /**
     * Formats the paylines filtering out the ones without gain.
     *
     * @param  mixed $paylines
     * @return The formatted paylines with gains.
     */
    private function formatPaylines($paylines) {
        $formattedArray = array();
        foreach($paylines as &$payline) {
            $matches = $payline->getMatches();
            if($matches > 0) {
                $formattedArray[$this->formatPaylineSequence($payline->getSequence())] = $matches;
            }
        }

        return $formattedArray;
    }

    /**
     * Formats the payline sequence.
     * @param  mixed $paylineSequence
     *
     * @return String The formatted payline's sequence.
     */
    private function formatPaylineSequence($paylineSequence) {
        $string = '';
        for ($i = 0; $i < count($paylineSequence); $i++) {
            $string .= $paylineSequence[$i] . " ";
        }
        return $string;
    }

    /**
     * Transforms an 2d array into a flat array.
     *
     * @param  mixed $arr
     * @return the flat array
     */
    private function toFlatArray($arr) {
        $flatArray = array();
        for ($row = 0; $row < count($arr); $row++) {
            for ($col = 0; $col < count($arr[$row]); $col++) {
                $flatArray[] = $arr[$row][$col];
            }
        }

        return $flatArray;
    }

    public function printResume() {
        echo json_encode($this) . "\n";
    }

    public function jsonSerialize() {
        return [
			'board' => $this->toFlatArray($this->board->getGrid()),
			'paylines' => $this->formatPaylines($this->paylines),
			'bet_amount' => $this->betAmount,
			'total_win' => $this->total_win
		];
    }
}
