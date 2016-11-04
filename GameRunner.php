<?php

include __DIR__.'/Game.php';
include __DIR__.'/Player.php';

$notAWinner;

  $aGame = new Game();
  
  $aGame->add(new Player("Chet"));
  $aGame->add(new Player("Pat"));
  $aGame->add(new Player("Sue"));
  
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
  
  
