<?php
function echoln($string) {
  echo $string."\n";
}

class Game {
    private $players;
    private $places;
    private $purses ;
    private $inPenaltyBox ;

    private $popQuestions;
    private $scienceQuestions;
    private $sportsQuestions;
    private $rockQuestions;

    private $currentPlayer = 0;
    private $isGettingOutOfPenaltyBox;
    private $categories;

    const MIN_PLAYERS = 2;

    function  __construct(){

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

	public function add($playerName) {
	   array_push($this->players, $playerName);
	   $this->places[$this->howManyPlayers()] = 0;
	   $this->purses[$this->howManyPlayers()] = 0;
	   $this->inPenaltyBox[$this->howManyPlayers()] = false;

	    echoln($playerName . " was added");
	    echoln("They are player number " . count($this->players));
		return true;
	}

	private function howManyPlayers() {
		return count($this->players);
	}

	public function  roll($roll) {
		echoln($this->players[$this->currentPlayer] . " is the current player");
		echoln("They have rolled a " . $roll);

		if ($this->inPenaltyBox[$this->currentPlayer]) {
			if ($roll % 2 != 0) {
				$this->isGettingOutOfPenaltyBox = true;

				echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
			$this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
				if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

				echoln($this->players[$this->currentPlayer]
						. "'s new location is "
						.$this->places[$this->currentPlayer]);
				echoln("The category is " . $this->currentCategory());
				$this->askQuestion();
			} else {
				echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
				$this->isGettingOutOfPenaltyBox = false;
				}

		} else {

		$this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
			if ($this->places[$this->currentPlayer] > 11) $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

			echoln($this->players[$this->currentPlayer]
					. "'s new location is "
					.$this->places[$this->currentPlayer]);
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
		$_index = $this->places[$this->currentPlayer]%count($this->categories);
		return $this->categories[$_index];
	}

	public function wasCorrectlyAnswered() {
		$winner = true;
		if ($this->inPenaltyBox[$this->currentPlayer]){
			if ($this->isGettingOutOfPenaltyBox) {
				echoln("Answer was correct!!!!");
				$this->purses[$this->currentPlayer]++;
				echoln($this->players[$this->currentPlayer]. " now has ".$this->purses[$this->currentPlayer]. " Gold Coins.");

				$winner = $this->didPlayerWin();
			}
		} else {

			echoln("Answer was corrent!!!!");
			$this->purses[$this->currentPlayer]++;
			echoln($this->players[$this->currentPlayer]. " now has ".$this->purses[$this->currentPlayer]. " Gold Coins.");

			$winner = $this->didPlayerWin();
		}

		$this->currentPlayer++;
		if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

		return $winner;
	}

	public function wrongAnswer(){
		echoln("Question was incorrectly answered");
		echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
		$this->inPenaltyBox[$this->currentPlayer] = true;

		$this->currentPlayer++;
		if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;
		return true;
	}


	private function didPlayerWin() {
		return !($this->purses[$this->currentPlayer] == 6);
	}
}
