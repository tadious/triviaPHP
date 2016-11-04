<?php

require_once('./Game.php');
require_once('./Player.php');

class GameTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }

  /**
  * Call protected/private method of a class.
  *
  * @param object &$object    Instantiated object that we will run method on.
  * @param string $methodName Method name to call
  * @param array  $parameters Array of parameters to pass into method.
  *
  * @return mixed Method return.
  */
  public function invokeMethod(&$object, $methodName, array $parameters = array())
  {
    $reflection = new \ReflectionClass(get_class($object));
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
  }

  public function testIsPlayableWithNoPlayers() {
    $game = new Game();
    $this->assertEquals($game->isPlayable(), false);
  }

  public function testIsPlayableWithOnePlayer() {
    $game = new Game();
    $game->add(new Player("Player 1"));
    
    $this->assertEquals($game->isPlayable(), false);
  }

  public function testIsPlayableWithTwoPlayers()
  {
    $game = new Game();
    $game->add(new Player("Player 1"));

    $game->add(new Player("Player 2"));
    $this->assertEquals($game->isPlayable(), true);
  }

  public function testAddAndHowManyPlayers() {
  	$game = new Game();
  	$this->assertEquals($this->invokeMethod($game, 'howManyPlayers', array()), 0);

  	$game->add(new Player("Player 1"));
    $this->assertEquals($this->invokeMethod($game, 'howManyPlayers', array()), 1);

    $game->add(new Player("Player 2"));
    $this->assertEquals($this->invokeMethod($game, 'howManyPlayers', array()), 2);
  }


  public function testRollWhileInPenaltyBox() {
    $game = new Game();
    $player1 = new Player("Player 1");
    $player1->setInPenaltyBox(true);
    $player2 = new Player("Player 2");
    $game->add($player1);
    $game->add($player2);

    $game->roll(3);

    $this->assertEquals($player1->getIsGettingOutOfPenaltyBox(), true);
  }
}
?>
