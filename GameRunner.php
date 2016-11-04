<?php

include __DIR__.'/Game.php';

$notAWinner;

  $aGame = new Game();
  
  $aGame->add("Chet");
  $aGame->add("Pat");
  $aGame->add("Sue");
  
  if($aGame->isPlayable()) {
    do {
      
      $aGame->roll(rand(0,5) + 1);
      
      if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
      } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
      }
      
      
      
    } while ($notAWinner);  
  } else {
    echoln("Error: At least ". Game::MIN_PLAYERS." are required for the game to continue.");
  }
  
  
