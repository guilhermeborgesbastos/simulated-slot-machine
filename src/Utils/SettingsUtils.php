<?php

/*
 * An utilitarian class used to validate the Settings properties coming from the config file.
 *
 * P.S: Still a lot of improvements in the validation of the properties that will be done in a
 * second version.
 *
 * @author Guilherme Borge Bastos
 * @data   10/27/2019
*/

namespace App\Utils;

use App\Exceptions\ApplicationSettingsException;

class SettingsUtils {

    private static function validateBetAmount($betAmount) {
        if(!is_numeric($betAmount) || $betAmount < 1) {
            throw new ApplicationSettingsException('The ' . BET_AMOUNT . ' property is invalid : ' . $betAmount);
        }
    }

    private static function validateGrid($grid) {
        $isNotValidRows = !is_numeric($grid[ROWS]) || $grid[ROWS] < 3;
        $isNotValidCols = !is_numeric($grid[COLS]) || $grid[COLS] < 3;

        if(!is_array($grid) || $isNotValidRows || $isNotValidCols) {
            throw new ApplicationSettingsException('The ' . GRID . ' property is invalid.');
        }
    }

    private static function validateSymbols($symbols) {
        if(!is_array($symbols) || sizeof($symbols) < 2) {
            throw new ApplicationSettingsException('The ' . SYMBOLS . ' property is invalid.');
        }
    }

    private static function validatePaylines($paylines) {
        if(!is_array($paylines) || sizeof($paylines) < 1) {
            throw new ApplicationSettingsException('The ' . PAYLINES . ' property is invalid.');
        }
    }

    private static function validatePayouts($payouts) {
        if(!is_array($payouts) || sizeof($payouts) < 1) {
            throw new ApplicationSettingsException('The ' . PAYOUTS . ' property is invalid.');
        }
    }

    /**
     * Validates the Settings properties coming from the application's configuration.
     *
     * @return void
     */
    public static function validate($settings) {
        Self::validateBetAmount($settings[BET_AMOUNT]);
        Self::validateGrid($settings[GRID]);
        Self::validateSymbols($settings[SYMBOLS]);
        Self::validatePaylines($settings[PAYLINES]);
        Self::validatePayouts($settings[PAYOUTS]);
        return $settings;
    }
}
