<?php
/*
 * The Game class contains the life cycle of the Game together with its business logic.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/
namespace App;

use App\Models\Board;
use App\Models\Payline;
use App\DTO\ResponseDTO;

class Game {

    private $settings;
    private $paylines;
    private $payouts;
    private $board;
    private $bet_amount;

    public function __construct($settings) {
        $this->settings = $settings;
        $this->paylines = array();
        $this->payouts = array();
        $this->bet_amount = $this->setBetAmount($settings[BET_AMOUNT]);

        $this->board = new Board(
            $settings[GRID][COLS],
            $settings[GRID][ROWS]
        );

        $this->init();
    }

    /**
     * Sets the bet amount converting it to cents.
     *
     * @param  mixed $bet_amount
     * @return void
     */
    public function setBetAmount($bet_amount) {
        return $bet_amount * 100;
    }

    /**
     * Inits the game executions by executing the required routines.
     *
     * @return void
     */
    private function init() {
        $this->loadPaylines();
        $this->loadPayouts();
    }

    /**
     * Loads the payouts into the class's flow.
     *
     * @return void
     */
    private function loadPayouts() {
        foreach($this->settings[PAYOUTS] as $key => &$payout) {
            $this->payouts[$key] = $payout;
        }
    }

    /**
     * Loads the paylines into the class's flow.
     *
     * @return void
     */
    private function loadPaylines() {
        foreach($this->settings[PAYLINES] as &$payline) {
            $this->paylines[] = new Payline($payline);
        }
    }

    /**
     * Calculates the symbols' match by iterating over each pay line, looking for
     * sequential occurrences of the same symbol in the board (2d array). It sets
     * the $payline->setMatches property for each payline in case the sequential
     * occurrences are 3 or more in the payline.
     *
     * @return void
     */
    private function calculatePaylinesMatch() {

        foreach($this->paylines as &$payline) {

            $pipelineMatches = 0;
            $paylineSequence = $payline->getSequence();

            for ($i = 0; $i < sizeof($paylineSequence) - 1; $i++) {
                $currValue = $paylineSequence[$i];
                $nextValue = $paylineSequence[$i + 1];

                $elementCurr = $this->board->retrieveSymbol((int)$currValue);
                $elementNext = $this->board->retrieveSymbol((int)$nextValue);

                // If consecutive elements aren't the same, break it.
                if ($elementCurr != $elementNext) {
                    break;
                }

                $pipelineMatches++;
            }

            $payline->setMatches($pipelineMatches > 1 ? ++$pipelineMatches : 0);
        }
    }

    /**
     * Calculates the payment according to the number of matches for each pay-line.
     * Notice that the payline->getMatches() will be only Zero or greater than 2
     * considering the fact that only 3 or more consecutive symbols of the same
     * kind are considered payout.
     *
     * @return void
     */
    private function calculatePayout() {
        $won = 0;
        foreach($this->paylines as &$payline) {
            $matches = $payline->getMatches();
            if($matches > 0) {
                $won += ($this->payouts[$matches] / 100) * $this->bet_amount;
            }
        }
        return $won;
    }

    /**
     * Outputs the results of the match.
     *
     * @param  mixed $board
     * @param  mixed $paylines
     * @param  mixed $bet_amount
     * @param  mixed $total_win
     *
     * @return void
     */
    private static function outputResult($board, $paylines, $bet_amount, $total_win) {
        $response = new ResponseDTO($board, $paylines, $bet_amount, $total_win);
        $response->printResume();
        echo "\n";
    }

    /**
     * Starts the play of the game.
     *
     * @return void
     */
    public function play() {

        // It fills the board with the random symbols.
        // $this->board->fillMock();
        $this->board->fill();

        // Prints the grid for the better user experience.
        $this->board->printGrid();

        echo "\n";

        // Calculates the paylines for the match.
        $this->calculatePaylinesMatch();

        /*
        // In here just in case it's needed to 'debug' the paylines...
        foreach($this->paylines as &$payline) {
            echo $payline->toString() . "\n";
        }
        // */

        echo "\n";

        $total_win = $this->calculatePayout();
        Self::outputResult($this->board, $this->paylines, $this->bet_amount, $total_win);
    }
}
?>
