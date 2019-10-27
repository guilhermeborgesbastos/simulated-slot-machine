<?php

/*
 * An utilitarian class used to manipulate the Symbols coming from the config settings.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/

namespace App\Utils;

class SymbolUtils {

    /**
     * It randomly retrieves a symbol from the matrix of symbols available for the application.
     *
     * It uses the Mersenne Twister algorithm in order to achieve better performance and
     * increase the randomness.
     *
     * @param  mixed $symbols
     * @return void
     */
    static function fetchRandomValue($symbols) {
        $symbols = config('Settings.symbols');
        return $symbols[mt_rand(0, count($symbols) - 1)];
    }

}
