<?php

namespace app\tests\cases\models;

use app\models\Player;
use app\models\Board;

class PlayerTest extends \lithium\test\Unit {
	public function setUp() {}

	public function tearDown() {}

	public function testGettingMark() {
		$mark = Board::$_player_one_mark; 
		$player = Player::create(compact('mark'));
		$this->assertEqual($mark, $player->getMark());
		
		$mark = Board::$_player_two_mark; 
		$player = Player::create(compact('mark'));
		$this->assertEqual($mark, $player->getMark());
		
		$mark = Board::$_none_mark; 
		$player = Player::create(compact('mark'));
		$this->assertFalse($player->getMark());

		$mark = "gooby gabba";  
		$player = Player::create(compact('mark'));
		$this->assertFalse($player->getMark());
	}
	
	public function testGettingStats() {
		$player1 = Player::create(array('mark' => Board::$_player_one_mark));
		$player2 = Player::create(array('mark' => Board::$_player_two_mark));
		
		$x = $y = $n = 4; 
		$board = Board::create(compact('x','y', 'n')); 
		$board->dropOne(0, $player1->getMark()); 
		
		
		
	}
}
