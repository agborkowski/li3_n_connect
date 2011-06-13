<?php

namespace app\models;

class Board extends \lithium\data\Model {
	public $validates = array();

	protected $_meta = array('key' => '_id');
	protected $board = array();
	protected $map = array(); 
	protected $n = 4; 
	protected $x = 7;
	protected $y = 6;

	public static $_player_one_mark = 1; 
	public static $_player_two_mark = 2; 
	public static $_none_mark = 0; 

	/*
	 * @return int the size of the board horizontally  
	 */ 
	public function getX($board) { return $board->x; }
	/*
	 * @return int the size of the board vertically 
	 */ 
	public function getY($board) { return $board->y; }
	/*
	 * @return int the number of pieces to win the board
	 */ 
	public function getN($board) { return $board->n; }

	public static function create (array $data = array(), array $options = array()) { 
		$board = parent::create(); 
		$board->board = array(); 
		$board->n = isset($data['n']) && is_numeric($data['n']) ? $data['n'] : 4;
		$board->x = isset($data['x']) && is_numeric($data['x']) ? $data['x'] : 7;
		$board->y = isset($data['y']) && is_numeric($data['y']) ? $data['y'] : 6;
		$board->map = BoardMap::create($data);

		for ($i = 0; $i < $board->x; $i++) {
			$board->board[$i] = array();
			for ($j = 0; $j < $board->y; $j++) {
				$board->board[$i][$j] = Board::$_none_mark;
			}
		}
 
		return $board; 
	}

	public function dropOne($board, $x, $player_num) {
		if (! Board::isValidPiece($player_num) ||
			$x < 0 || $x > $board->getX()) {
			return false;
		}

		for ($i = 0; $i < $board->getY();$i++) {
			if ($board->getSpotOwner($x, $i) == Board::$_none_mark) {
				$board->board[$x][$i] = $player_num;
			
				if ( $board->save()) { 
					error_log("spot owner should be $player_num; is : " . $board->getSpotOwner($x, $i)); 
					var_dump($board->board[$x]->to('array')  );
					return $i; 
				}
			}
		}
	}

	public function getSpotOwner($board, $x, $y) {
		if ($x < $board->getX() && $x >= 0 && 
			$y < $board->getY() && $y >= 0) {
			return $board->board[$x][$y]; 
		}
		return false; 
	}

	public function getMapListings($board, $x, $y) {
		if ($x >= $board->getX() || $x < 0 || 
			$y >= $board->getY() || $y < 0) {
				return false; 
		}
		return $board->map->getListings($x, $y); 
	}
	
	public function getLocationsByListing($board, $listing_num) {
		return $board->map->getLocationsByListing($listing_num);
	}

	public function getListingCount($board) { 
		return $board->map->getListingCount(); 
	}
	
	public static function isValidPiece($piece) {
		return $piece == Board::$_player_one_mark ||
			$piece == Board::$_player_two_mark; 
	}
	public function getStatForListing($board, $owner_num, $listing_num) {
		if (! is_numeric($listing_num) || ! Board::isValidPiece($owner_num)) {
			return false;
		}

		$locations = $board->getLocationsByListing($listing_num); 
		$stat = 1; 
		foreach ($locations as $location) {
			$owner = $board->getSpotOwner($location['x'], $location['y']); 
			if ($owner == $owner_num) { 
				$stat =  2 * $stat; 
			} else if (Board::isValidPiece($owner)) {
				return 0; 
			}
		}
		return $stat; 
	}
}
