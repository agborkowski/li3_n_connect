<?php

namespace app\models;

class BoardMap extends \lithium\data\Model {
	public $validates = array();
	
	protected $_listing = array(); 
	protected $_listing_by_num = array(); 
	protected $_x = 0; 
	protected $_y = 0; 
	protected $_n = 0; 

	/*
	 * @return int the size of the map horizontally
	 */
	public function getX($board_map) { return $board_map->_x; }
	/*
	 * @return int the size of the map vertically 
	 */
	public function getY($board_map) { return $board_map->_y; }
	/*
	 * @return int the number of blocks in a line to win 
	 */
	public function getN($board_map) { return $board_map->_n; }
	/*
	 * @return array the listing of all the combinations of a board
	 */
	public function getListing($board_map) { return $board_map->_listing->to('array'); }

	/*
	 * extension of Model::create
	 *
	 * @return BoardMap
	 */
	public static function create (array $data = array(), array $options = array()) {
		$board_map = parent::create(); 

		//var_dump($data); 
		$board_map->_n = isset($data['n']) && is_numeric($data['n']) ? $data['n'] : 0;
		$board_map->_x = isset($data['x']) && is_numeric($data['x']) ? $data['x'] : 0;
		$board_map->_y = isset($data['y']) && is_numeric($data['y']) ? $data['y'] : 0;
	


		if (! ($board_map->_n && $board_map->_x && $board_map->_y) || 
				! ($board_map->_x >= $board_map->_n || $board_map->_y >= $board_map->_n)) {
			return false; 
		}

		$board_map->_generate_listing(); 

		return $board_map;
	}
	
	/*
	 * generates a listing based on the current map 
	 * 
	 * @return null, but has side effects
	 */
	public function _generate_listing($board_map) {
		$listings = array(); 
		$listing_by_num = array(); 
		// set up listing array
		for ($i = 0; $i < $board_map->getX(); $i++) {
			$listings[$i] = array(); 
			for ($j = 0; $j < $board_map->getY(); $j++) {
				$listings[$i][$j] = array();
			}
		}
		
		$win_index = 0;
		
		// horizontal
		for ($i = 0; $i < $board_map->getY(); $i++) {
			for ($j = 0; $j < ($board_map->getX() - $board_map->getN() + 1); $j++) {
				if (! isset($listing_by_num[$win_index]) ||
						! is_array($listing_by_num[$win_index])) { 
					$listing_by_num[$win_index] = array(); 
				}
				for ($k = 0; $k < $board_map->getN(); $k++) {
					if (! isset($listings[$j+$k][$i]) || ! is_array($listings[$j+$k][$i])) {
						$listings[$j+$k][$i] = array();
					}
					array_push($listing_by_num[$win_index], array('x' => ($j+$k), 'y' => $i));
					array_push($listings[$j+$k][$i], $win_index);
				}
				$win_index++; 
			}
		}
		
		// vertical 
		for ($i = 0; $i < $board_map->getX(); $i++) {
			for ($j = 0; $j < ($board_map->getY() - $board_map->getN() + 1); $j++) {
				if (! isset($listing_by_num[$win_index]) || 
						! is_array($listing_by_num[$win_index])) { 
					$listing_by_num[$win_index] = array(); 
				}
				for ($k = 0; $k < $board_map->getN(); $k++) {
					if (! isset($listings[$i][$j+$k]) || ! is_array($listings[$i][$j+$k])) {
						$listings[$i][$j+$k] = array();
					}
					array_push($listings[$i][$j+$k], $win_index);
					array_push($listing_by_num[$win_index], array('x' => $i, 'y' => ($j+$k)));
				}
				$win_index++;
			}
		}
		
		//forward diagonal
		for ($i = 0; $i < ($board_map->getY() - $board_map->getN()+1); $i++) {
			for ($j = 0; $j < ($board_map->getX() - $board_map->getN()+1); $j++) {
				if (! isset($listing_by_num[$win_index]) || 
						! is_array($listing_by_num[$win_index])) { 
					$listing_by_num[$win_index] = array(); 
				}
				for ($k = 0; $k < $board_map->getN(); $k++) {
					if (! isset($listings[$j+$k][$i+$k]) || 
							! is_array($listings[$j+$k][$i+$k])) {
						$listings[$j+$k][$i+$k] = array();
					}
					array_push($listings[$j+$k][$i+$k], $win_index);
					array_push($listing_by_num[$win_index], array('x' => ($j+$k), 'y' => ($i+$k)));
				}
				$win_index++;
			}
		}
		
		//backward diagonal
		for ($i = 0; $i < ($board_map->getY() - $board_map->getN() + 1); $i++) {
			for ($j = ($board_map->getX() - 1); $j >= ($board_map->getN() -1); $j--) {
				if (! isset($listing_by_num[$win_index]) || 
						! is_array($listing_by_num[$win_index])) { 
					$listing_by_num[$win_index] = array(); 
				}
				for ($k = 0; $k < $board_map->getN(); $k++) {
					if (! isset($listings[$j-$k][$i+$k]) || 
							! is_array($listings[$j-$k][$i+$k])) {
						$listings[$j-$k][$i+$k] = array(); 
					}
					array_push($listings[$j-$k][$i+$k], $win_index);
					array_push($listing_by_num[$win_index], array('x' => ($j-$k), 'y' => ($i+$k)));
				}
				$win_index++;
			}
		}
		
		$board_map->_listing = $listings; 
		$board_map->_listing_by_num = $listing_by_num; 
	}
	
	/*
	 * @return array the list of all the listings of winning combinations for this square
	 */
	public function getListings($board_map, $x, $y) {
		if ($x < $board_map->getX() && $x >= 0 && 
			$y < $board_map->getY() && $y >= 0) {
			$listing = $board_map->_listing->to('array');

			return isset($listing[$x][$y]) ? $listing[$x][$y] : array() ; 
		}
		return false;
	}

	/*
	 * @return array the list of locations for this board number
	 */
	public function getLocationsByListing($board_map, $listing_num) {
		if (! is_numeric($listing_num) || 
				! isset($board_map->_listing_by_num[$listing_num])) {
			return false; 
		}
		return $board_map->_listing_by_num[$listing_num]->to('array');
	}
	
	public function getListingCount($board_map) {
		return count($board_map->_listing_by_num->to('array')); 
	}
}
