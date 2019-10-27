<?php

/*
 * This file contains the configurations for the application works. The intent here is to be
 * able to change the application's metrics without touch the concrete implementation.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/


define("SETTINGS", "Settings");
define("BET_AMOUNT", "bet_amount");
define("GRID", "grid");
define("ROWS", "rows");
define("COLS", "columns");
define("SYMBOLS", "symbols");
define("PAYLINES", "paylines");
define("PAYOUTS", "payouts");

return [

    // The bet's total amount.
    BET_AMOUNT => 1,

    // The dimensions of the grid (2d Array) that will contain the random symbols.
    GRID => [
        ROWS => 3,
        COLS => 5
    ],

    // The symbols that are available to randomly fill the grid (2d array).
    SYMBOLS => [
        '9', '10', 'J', 'Q', 'K',
        'A', 'cat', 'dog', 'monkey', 'bird'
    ],

    /*
     * The matrix that contains the payline sequences. A payout happens when 3 or more
     * consecutive symbols of the same kind are present in a payline, always starting
     * from the first column (0, 1, 2).
    */
    PAYLINES => [
        [0, 3, 6, 9,  12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14]
    ],

    /*
     * The payout matrix, containing the number of consecutive symbols in the grid (2d matrix)
     * based on the paylines. It has its Key as the number of consecutive symbols and the value
     * as the percentage of earning over the bet amount.
    */
    PAYOUTS => [
        3 => 20,
        4 => 200,
        5 => 1000
    ]
];
?>
