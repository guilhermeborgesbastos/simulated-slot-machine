<?php
/*
 * A custom command used to invoke the 'Game Play'.
 *
 * Command line:
 * php artisan game:execute
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Game;

class ExecuteGame extends Command {

    private $game;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:execute';
    protected $description = "Executes the VideoSlots' demo game, developed by Guilherme Borges Bastos. Based on a technical exercise.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->game = new Game(config(SETTINGS));
    }

    /**
     * Execute the console command playing the Game.
     *
     * @return mixed
     */
    public function handle()
    {
        // Fills the board with random symbols.
        $this->game->getBoard()->fillRandomly();

        // Start the game execution.
        $gameMatch = $this->game->play();

        // Prints the match status in the console.
        $gameMatch->printResume();
    }
}
