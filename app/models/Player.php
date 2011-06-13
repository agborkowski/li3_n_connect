<?php

namespace app\models;

use app\models\Board;

class Player extends \lithium\data\Model {

	public $validates = array();
	private $_stats = array();
	private $_mark = null;
	private $_board = array(); 

	public static function create (array $data = array(), array $options = array()) { 
		$player = parent::create();
		$player->_stats = array();
		$player->_board = isset($data['board']) ? $data['board'] : array();
		$player->_mark = (isset($data['mark']) && Board::isValidPiece($data['mark'])) ? $data['mark'] : Board::$_none_mark;
		return $player;  
	}
	
	public function getMark($player) {
		return $player->_mark; 
	}
	
	public function getStats ($player, $board = false, $x = -1, $y = -1) {
		if (! $board) {
			$board = $player->board; 
		}
	}
}