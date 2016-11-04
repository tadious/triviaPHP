<?php
function echoln($string) {
  echo $string."\n";
}

class Game {
    private $players;

    private $popQuestions;
    private $scienceQuestions;
    private $sportsQuestions;
    private $rockQuestions;

    private $currentPlayer = 0;
    private $categories;

    const MIN_PLAYERS = 2;

    public function  __construct() {

   		$this->players = array();
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        $this->popQuestions = array();
        $this->scienceQuestions = array();
        $this->sportsQuestions = array();
        $this->rockQuestions = array();

        $this->categories = array("Pop", "Science", "Sports", "Rock");

        for ($i = 0; $i < 50; $i++) {
			array_push($this->popQuestions, $this->createQuestion($this->categories[0], $i));
			array_push($this->scienceQuestions, $this->createQuestion($this->categories[1], $i));
			array_push($this->sportsQuestions, $this->createQuestion($this->categories[2], $i));
			array_push($this->rockQuestions, $this->createQuestion($this->categories[3], $i));
    	}
    }

    private function createQuestion($category, $index) {
    	return $category. " Question ". $index;
    }

	public function isPlayable() {
		return ($this->howManyPlayers() >= self::MIN_PLAYERS);
	}

	public function add($player) {
	   array_push($this->players, $player);

	    echoln($player->getName() . " was added");
	    echoln("They are player number " . count($this->players));
		return true;
	}

	private function howManyPlayers() {
		return count($this->players);
	}

	public function  roll($roll) {
		echoln($this->players[$this->currentPlayer]->getName() . " is the current player");
		echoln("They have rolled a " . $roll);

		if ($this->players[$this->currentPlayer]->getInPenaltyBox()) {
			if ($roll % 2 != 0) {
				$this->players[$this->currentPlayer]->setIsGettingOutOfPenaltyBox(true);

				echoln($this->players[$this->currentPlayer]->getName() . " is getting out of the penalty box");
				$this->players[$this->currentPlayer]->setPlace($this->players[$this->currentPlayer]->getPlace() + $roll);
				if ($this->players[$this->currentPlayer]->getPlace() > 11) 
					$this->players[$this->currentPlayer]->setPlace($this->players[$this->currentPlayer]->getPlace() - 12);

				echoln($this->players[$this->currentPlayer]->getName(). "'s new location is ".$this->players[$this->currentPlayer]->getPlace());
				echoln("The category is " . $this->currentCategory());
				$this->askQuestion();
			} else {
				echoln($this->players[$this->currentPlayer]->getName() . " is not getting out of the penalty box");
				$this->players[$this->currentPlayer]->setIsGettingOutOfPenaltyBox(false);
			}

		} else {

			$this->players[$this->currentPlayer]->setPlace($this->players[$this->currentPlayer]->getPlace() + $roll);
			if ($this->players[$this->currentPlayer]->getPlace() > 11) 
				$this->players[$this->currentPlayer]->setPlace($this->players[$this->currentPlayer]->getPlace() - 12);

			echoln($this->players[$this->currentPlayer]->getName(). "'s new location is ".$this->players[$this->currentPlayer]->getPlace());
			echoln("The category is " . $this->currentCategory());
			$this->askQuestion();
		}

	}

	private function  askQuestion() {
		$_currentCategory = $this->currentCategory();
		switch($_currentCategory) {
			case "Pop";
				echoln(array_shift($this->popQuestions));
			break;

			case "Science";
				echoln(array_shift($this->scienceQuestions));
			break;

			case "Sports";
				echoln(array_shift($this->sportsQuestions));
			break;

			case "Rock";
				echoln(array_shift($this->rockQuestions));
			break;
		}
	}


	private function currentCategory() {
		$_index = $this->players[$this->currentPlayer]->getPlace()%count($this->categories);
		return $this->categories[$_index];
	}

	private function correctAnswer() {
		$isNotAWinner = true;
		if ($this->players[$this->currentPlayer]->getInPenaltyBox()){
			if ($this->players[$this->currentPlayer]->getIsGettingOutOfPenaltyBox()){
				echoln("Answer was correct!!!!");
				$this->players[$this->currentPlayer]->setPurse($this->players[$this->currentPlayer]->getPurse() + 1);
				echoln($this->players[$this->currentPlayer]->getName(). " now has ".$this->players[$this->currentPlayer]->getPurse(). " Gold Coins.");

				$isNotAWinner = $this->players[$this->currentPlayer]->isNotTheWinner();
			}
		} else {

			echoln("Answer was corrent!!!!");
			$this->players[$this->currentPlayer]->setPurse($this->players[$this->currentPlayer]->getPurse() + 1);
			echoln($this->players[$this->currentPlayer]->getName(). " now has ".$this->players[$this->currentPlayer]->getPurse(). " Gold Coins.");

			$isNotAWinner = $this->players[$this->currentPlayer]->isNotTheWinner();
		}

		$this->currentPlayer++;
		if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

		return $isNotAWinner;
	}

	private function wrongAnswer(){
		echoln("Question was incorrectly answered");
		echoln($this->players[$this->currentPlayer]->getName() . " was sent to the penalty box");
		$this->players[$this->currentPlayer]->setInPenaltyBox(true);

		$this->currentPlayer++;
		if ($this->currentPlayer == count($this->players)) 
			$this->currentPlayer = 0;
		return true;
	}

	public function getAnswer() {
	  	if (rand(0,9) == 7) {
        	return $this->wrongAnswer();
      	} else {
        	return $this->correctAnswer();
      	}
	}
}
