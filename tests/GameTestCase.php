<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Game;

class GameTestCase extends TestCase {

    private $game;
    private $testSettings;

    /*
     * It's necessary to tell PHPUnit not to preserve global state between tests and
     * to run each test in a separate process.
     */
    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;

    protected function setUp(): void {
        $this->testSettings = require_once("Mock/SettingsMock.php");
        $this->game = new Game($this->testSettings);
    }

    /**
     * The basic test based on the test case provided in the Technical test
     * description.
     *
     * @return void
     */
    public function testGamePlay() {

        $mockedGrid = array(
            array('J', 'J', 'J', 'Q', 'K'),
            array('Cat', 'J', 'Q', 'Mon', 'Bir'),
            array('Bir', 'Bir', 'J', 'Q', 'A')
        );

        // Sets the mocked grid data
        $this->game->setBoardGrid($mockedGrid);

        $gameMatchDTO = $this->game->play();

        $this->assertNotNull($gameMatchDTO, 'The Game object must not be null.');

        // Assert values coming from the Data Transfer Object

        // Assets the total won property.
        $totalWon = $gameMatchDTO->getTotalWon();
        $this->assertIsFloat($totalWon, 'Invalid data type for the total won.');
        $this->assertEquals($totalWon, 40.0, 'Error to calculate the total won.');

        // Assets the bet amount property.
        $betAmount = $gameMatchDTO->getBetAmount();
        $this->assertIsInt($betAmount, 'Invalid data type for the bet amount.');
        $this->assertEquals($betAmount, 100, 'Error to set the the bet amount.');

        // Asserts in the Board Grid property
        $board = $gameMatchDTO->getBoard();
        $this->assertNotNull($board->getColumns(), 'The board columns must not be null.');
        $this->assertIsInt($board->getColumns(), 'Invalid data type for the board columns.');
        $this->assertEquals($board->getColumns(), $this->testSettings[GRID][COLS],
            'Invalid amount of columns based on the application settings.');

        $this->assertNotNull($board->getRows(), 'The board rows must not be null.');
        $this->assertIsInt($board->getRows(), 'Invalid data type for the board rows.');
        $this->assertEquals($board->getRows(), $this->testSettings[GRID][ROWS],
            'Invalid amount of rows based on the application settings.');

        $boardGrid = $gameMatchDTO->getBoard()->getGrid();
        $this->assertIsArray($boardGrid, "The board's grid must be an array.");
        $this->assertEquals(sizeof($boardGrid), $this->testSettings[GRID][ROWS],
            "The board's grid rows size is incorrect.");
        $this->assertEquals(sizeof($boardGrid[0]), $this->testSettings[GRID][COLS],
            "The board's grid columns size is incorrect.");

        // Asserts in the paylines property
        $paylines = $gameMatchDTO->getPaylines();
        $this->assertNotNull($paylines, 'The paylines must not be null.');
        $this->assertIsArray($paylines, "The paylines must be an array.");
        $this->assertEquals(sizeof($paylines), sizeof($this->testSettings[PAYLINES]),
            "The paylines size is incorrect.");

        // Asserts the total of 'gain' paylines
        $this->assertEquals($paylines[0]->getMatches(), 3, "The payline[0] has incorrect matches.");
        $this->assertEquals($paylines[1]->getMatches(), 0, "The payline[1] has incorrect matches.");
        $this->assertEquals($paylines[2]->getMatches(), 0, "The payline[2] has incorrect matches.");
        $this->assertEquals($paylines[3]->getMatches(), 3, "The payline[3] has incorrect matches.");
        $this->assertEquals($paylines[4]->getMatches(), 0, "The payline[4] has incorrect matches.");
    }
}

?>
