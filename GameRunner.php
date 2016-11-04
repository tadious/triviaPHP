<?php

  include __DIR__.'/Game.php';
  include __DIR__.'/Player.php';

  $notAWinner = false;

  $aGame = new Game();
  
  $aGame->add(new Player("Chet"));
  $aGame->add(new Player("Pat"));
  $aGame->add(new Player("Sue"));
  
  if($aGame->isPlayable()) {
    do {
      
      $aGame->roll(rand(0,5) + 1);
      $notAWinner = $aGame->getAnswer();
      
    } while ($notAWinner);  
  } else {
    echoln("Error: At least ". Game::MIN_PLAYERS." are required for the game to continue.");
  }
  
?>  
