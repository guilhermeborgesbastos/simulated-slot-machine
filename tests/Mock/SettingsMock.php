<?php
/*
 * This file contains the dump data with the configurations for the Unit Tests.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/

return [

    BET_AMOUNT => 1,
    GRID => [
        ROWS => 3,
        COLS => 5
    ],
    SYMBOLS => [
        '9', '10', 'J', 'Q', 'K',
        'A', 'cat', 'dog', 'monkey', 'bird'
    ],
    PAYLINES => [
        [0, 3, 6, 9,  12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14]
    ],
    PAYOUTS => [
        3 => 20,
        4 => 200,
        5 => 1000
    ]
];
?>
