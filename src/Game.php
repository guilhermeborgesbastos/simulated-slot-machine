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
use App\Utils\SettingsUtils;

class Game {

    private $betAmount;
    private $settings;
    private $paylines;
    private $payouts;
    private $board;

    public function __construct($settings) {
        $this->betAmount = $this->setBetAmount($settings[BET_AMOUNT]);
        $this->settings = $this->setSettings($settings);
        $this->paylines = array();
        $this->payouts = array();

        $this->board = new Board(
            $settings[GRID][COLS],
            $settings[GRID][ROWS]
        );

        $this->init();
    }

    /**
     * Sets the configuration setting doing the required validations.
     *
     * @param  mixed $settings
     * @return The settings
     */
    public function setSettings($settings) {
        return SettingsUtils::validate($settings);
    }

    /**
     * Sets the bet amount converting it to cents.
     *
     * @param  mixed $betAmount
     * @return The bet amount
     */
    public function setBetAmount($betAmount) {
        return $betAmount * 100;
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
                $won += ($this->payouts[$matches] / 100) * $this->betAmount;
            }
        }
        return $won;
    }

    /**
     * Outputs the results of the match.
     *
     * @param  mixed $board
     * @param  mixed $paylines
     * @param  mixed $betAmount
     * @param  mixed $totalWon
     *
     * @return void
     */
    private static function outputResult($board, $paylines, $betAmount, $totalWon) {
        $response = new ResponseDTO($board, $paylines, $betAmount, $totalWon);
        $response->printResume();
    }

    static function breakLine() {
        echo "\n";
    }

    /**
     * Starts the play of the game.
     *
     * @return void
     */
    public function play() {

        // It fills the board with random symbols.
        // $this->board->fillMock();
        $this->board->fill();

        // Prints the grid for the better user experience.
        $this->board->printGrid();
        Self::breakLine();

        // Calculates the paylines for the match.
        $this->calculatePaylinesMatch();
        Self::breakLine();

        $totalWon = $this->calculatePayout();
        Self::outputResult($this->board, $this->paylines, $this->betAmount, $totalWon);
    }
}
?>
