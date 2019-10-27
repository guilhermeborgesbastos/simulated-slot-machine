<?php

namespace App\Models;

class Payline {

    private $sequence;
    private $matches;

    public function __construct($sequence = array()) {
        $this->sequence = $sequence;
        $this->matches = 0;
    }

    public function getSequence() {
        return $this->sequence;
    }

    public function getMatches() {
        return $this->matches;
    }

    public function setMatches($matches) {
        $this->matches = $matches;
    }

    public function toString() {
        $string = '';
        foreach ($this->sequence as $value){
            $string .=  $value.',';
        }

        return $string . " (" . $this->getMatches() . ")";
    }
}
