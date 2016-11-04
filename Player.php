<?php

class Player {

	private $name;
	private $place;
    private $purse;
    private $inPenaltyBox;
    private $isGettingOutOfPenaltyBox;

    const WINNING_COINS = 6;

    public function  __construct($name) {
    	$this->name = $name;
    	$this->place = 0;
    	$this->purse = 0;
    	$this->inPenaltyBox = false;
    	$this->isGettingOutOfPenaltyBox = false;
    }

    public function setName($name) {
    	$this->name = $name;
    }

    public function getName() {
    	return $this->name;
    }

    public function setPlace($place) {
    	$this->place = $place;
    }

    public function getPlace() {
    	return $this->place;
    }

    public function setPurse($purse) {
    	$this->purse = $purse;
    }

    public function getPurse() {
    	return $this->purse;
    }

    public function setInPenaltyBox($inPenaltyBox) {
    	$this->inPenaltyBox = $inPenaltyBox;
    }

    public function getInPenaltyBox() {
    	return $this->inPenaltyBox;
    }

    public function setIsGettingOutOfPenaltyBox($isGettingOutOfPenaltyBox) {
    	$this->isGettingOutOfPenaltyBox = $isGettingOutOfPenaltyBox;
    }

    public function getIsGettingOutOfPenaltyBox() {
    	return $this->isGettingOutOfPenaltyBox;
    }

    public function isNotTheWinner() {
    	return !($this->purse === self::WINNING_COINS);
    }
}

?>