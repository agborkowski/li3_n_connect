<?php

namespace app\tests\cases\models;

use app\models\Board;

class BoardTest extends \lithium\test\Unit {
	public function setUp() {
		$this->boards = array(); 
	}

	public function tearDown() {
		foreach ($this->boards as $board) {
			if ($board) { $board->delete(); } 
		}
	}

	public function testCreation() {
		$board = Board::create(); 
		$board->save();
		$this->boards[] = $board; 
		$this->assertEqual(7, $board->getX());
		$this->assertEqual(6, $board->getY());
		$this->assertEqual(4, $board->getN());
	
		$board = Board::create(array("n"=>5, "x"=>20, "y"=>10));
		$board->save();
		$this->boards[] = $board; 
		$this->assertEqual(20, $board->getX());
		$this->assertEqual(10, $board->getY());
		$this->assertEqual(5, $board->getN());
	}

	public function testDropping() {
		$board = Board::create();
		$board->save();

		$this->boards[] = $board; 

		$this->assertFalse($board->getSpotOwner(-1, 0)); 
		$this->assertFalse($board->getSpotOwner(0, -1)); 
		$this->assertFalse($board->getSpotOwner($board->getX(), 0));
		$this->assertFalse($board->getSpotOwner($board->getX() - 2, $board->getY())); 
		$this->assertFalse($board->dropOne(-1, Board::$_player_one_mark)); 
		$this->assertFalse($board->dropOne(20, Board::$_player_one_mark)); 
		$this->assertEqual(0, $board->dropOne(3, Board::$_player_one_mark)); 
		$this->assertEqual(Board::$_player_one_mark, 
			$board->getSpotOwner(3, 0));
		$this->assertEqual(1, $board->dropOne(3, Board::$_player_two_mark)); 
		$this->assertEqual(Board::$_player_two_mark, 
			$board->getSpotOwner(3, 1)); 
		$this->assertEqual(0, $board->dropOne(4, Board::$_player_two_mark)); 
		$this->assertEqual(Board::$_player_two_mark, 
			$board->getSpotOwner(4, 0)); 
	}

	public function testingMapListings() {
		$x = 7; 
		$y = 6; 
		$n = 4; 
		$board = Board::create(compact('x', 'y', 'n')); 
		$board->save(); 
		$this->boards[] = $board; 
		$this->assertFalse($board->getMapListings($x, 0)); 
		$this->assertFalse($board->getMapListings($x+1, 0)); 
		$this->assertFalse($board->getMapListings(-1, 0)); 
		$this->assertFalse($board->getMapListings(0, $y)); 
		$this->assertFalse($board->getMapListings(0, $y+1)); 
		$this->assertFalse($board->getMapListings(0, -1)); 
		
		// see http://www.pomakis.com/c4/connect_generic/c4.txt for graph 
		$this->assertEqual(3, count($board->getMapListings(0,0))); 
		$this->assertEqual(4, count($board->getMapListings(0,1))); 
		$this->assertEqual(5, count($board->getMapListings(0,2))); 
		$this->assertEqual(5, count($board->getMapListings(0,3))); 
		$this->assertEqual(4, count($board->getMapListings(0,4))); 
		$this->assertEqual(3, count($board->getMapListings(0,5))); 

		$this->assertEqual(4, count($board->getMapListings(1,0))); 
		$this->assertEqual(6, count($board->getMapListings(1,1))); 
		$this->assertEqual(8, count($board->getMapListings(1,2))); 
		$this->assertEqual(8, count($board->getMapListings(1,3))); 
		$this->assertEqual(6, count($board->getMapListings(1,4))); 
		$this->assertEqual(4, count($board->getMapListings(1,5))); 

		$this->assertEqual(5, count($board->getMapListings(2,0))); 
		$this->assertEqual(8, count($board->getMapListings(2,1))); 
		$this->assertEqual(11, count($board->getMapListings(2,2))); 
		$this->assertEqual(11, count($board->getMapListings(2,3))); 
		$this->assertEqual(8, count($board->getMapListings(2,4))); 
		$this->assertEqual(5, count($board->getMapListings(2,5))); 

		$this->assertEqual(7, count($board->getMapListings(3,0))); 
		$this->assertEqual(10, count($board->getMapListings(3,1))); 
		$this->assertEqual(13, count($board->getMapListings(3,2))); 
		$this->assertEqual(13, count($board->getMapListings(3,3))); 
		$this->assertEqual(10, count($board->getMapListings(3,4))); 
		$this->assertEqual(7, count($board->getMapListings(3,5))); 

		$this->assertEqual(5, count($board->getMapListings(4,0))); 
		$this->assertEqual(8, count($board->getMapListings(4,1))); 
		$this->assertEqual(11, count($board->getMapListings(4,2))); 
		$this->assertEqual(11, count($board->getMapListings(4,3))); 
		$this->assertEqual(8, count($board->getMapListings(4,4))); 
		$this->assertEqual(5, count($board->getMapListings(4,5))); 

		$this->assertEqual(4, count($board->getMapListings(5,0))); 
		$this->assertEqual(6, count($board->getMapListings(5,1))); 
		$this->assertEqual(8, count($board->getMapListings(5,2))); 
		$this->assertEqual(8, count($board->getMapListings(5,3))); 
		$this->assertEqual(6, count($board->getMapListings(5,4))); 
		$this->assertEqual(4, count($board->getMapListings(5,5))); 

		$this->assertEqual(3, count($board->getMapListings(6,0))); 
		$this->assertEqual(4, count($board->getMapListings(6,1))); 
		$this->assertEqual(5, count($board->getMapListings(6,2))); 
		$this->assertEqual(5, count($board->getMapListings(6,3))); 
		$this->assertEqual(4, count($board->getMapListings(6,4))); 
		$this->assertEqual(3, count($board->getMapListings(6,5))); 
	}

	public function testValidPiece() {
		$board = Board::create(); 
		$board->save();
		$this->boards[] = $board; 


		$this->assertTrue(Board::isValidPiece(Board::$_player_one_mark)); 
		$this->assertTrue(Board::isValidPiece(Board::$_player_two_mark)); 
		$this->assertFalse(Board::isValidPiece(Board::$_none_mark)); 
		$this->assertFalse(Board::isValidPiece("goabbbly gook"));  
		
	}
	
	public function testGetLocationsByListing() {
		$x = $n = 4; 
		$y = 1;
		$board = Board::create(compact('x','y','n')); 
		$board->save();
		$this->boards[] = $board; 

		$listing1 = $board->getLocationsByListing(0);
		$this->assertTrue(is_array($listing1));
		for ($i = 0; $i < $x; $i++) {
			$this->assertTrue(isset($listing1[$i]));
			$this->assertEqual(array('x' => $i, 'y' => 0), $listing1[$i]);
		}
		$this->assertFalse($board->getLocationsByListing(1)); 
		
		$y = 2; 
		$board = Board::create(compact('x','y','n')); 
		$board->save();
		$this->boards[] = $board; 
		for($list_num = 0; $list_num < 2; $list_num++) { 
			$listing = $board->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => $i, 'y' => $list_num), $listing[$i]);
			}
		}
		$this->assertFalse($board->getLocationsByListing(3)); 


		$x = $n = $y = 4;
		
		$board = Board::create(compact('x','y','n'));
		$board->save();
		$this->boards[] = $board; 
		// horizontal 
		for ($list_num = 0; $list_num < 4; $list_num++) { 
			$listing = $board->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => $i, 'y' => $list_num), $listing[$i]);
			}
		}
		
		for ($list_num = 4; $list_num < 8; $list_num++) {
			$listing = $board->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => ($list_num-4), 'y' => $i), $listing[$i]);
			}
		}
		
		$listing = $board->getLocationsByListing(8); 
		$this->assertTrue(is_array($listing));
		for ($i = 0; $i < 4; $i++) {
			
			$this->assertTrue(isset($listing[$i]));
			$this->assertEqual(array('x' => $i, 'y' => $i), $listing[$i]);
		}
		$listing = $board->getLocationsByListing(9); 
		$this->assertTrue(is_array($listing)); 
		for ($i = 0; $i < 4; $i++) {
			$this->assertTrue(isset($listing[$i]));
			$this->assertEqual(array('x' => (3-$i), 'y' =>$i), $listing[$i]);
		}
		
		$this->assertFalse($board->getLocationsByListing(10)); 
	}

	public function testGetStats() {
		$x = $y = $n = 4;
		$listing_num = 0; 
		$board = Board::create(compact('x','y','n')); 

		$board->save();
		$this->boards[] = $board; 

		$this->assertFalse($board->getStatForListing(10000, $listing_num));
		$this->assertFalse($board->getStatForListing(Board::$_player_one_mark, "abc")); 
		$this->assertTrue($listing_num < $board->getListingCount());  
		$this->assertEqual(1, $board->getStatForListing(Board::$_player_one_mark, $listing_num));
		$this->assertEqual(1, $board->getStatForListing(Board::$_player_two_mark, $listing_num));
		
		$locations = $board->getLocationsByListing(1); 
		$this->assertTrue(is_array($locations)); 
		for ($i = 0; $i < count($locations); $i++)  { 
			$this->assertTrue(is_array($locations[$i])); 
			$this->assertTrue(isset($locations[$i]['x'])); 
			$board->dropOne($locations[$i]['x'], Board::$_player_one_mark);
			$this->assertEqual(Board::$_player_one_mark, $board->getSpotOwner($locations[$i]['x'], 0)); 
			$this->assertEqual(pow(2,($i+1)), $board->getStatForListing(Board::$_player_one_mark, $listing_num));
			$this->assertEqual(0, $board->getStatForListing(Board::$_player_two_mark, $listing_num));
		}

		$listing_num++; 
		$this->assertTrue($listing_num < $board->getListingCount());  
		$this->assertEqual(1, $board->getStatForListing(Board::$_player_one_mark, $listing_num));
		$this->assertEqual(1, $board->getStatForListing(Board::$_player_two_mark, $listing_num));
		
		$locations = $board->getLocationsByListing(1); 
		$this->assertTrue(is_array($locations)); 
		for ($i = 0; $i < count($locations); $i++)  { 
			$this->assertTrue(is_array($locations[$i])); 
			$this->assertTrue(isset($locations[$i]['x'])); 
			
			$board->dropOne($locations[$i]['x'], Board::$_player_two_mark); 
			$this->assertEqual(pow(2,($i+1)), $board->getStatForListing(Board::$_player_two_mark, $listing_num));
			$this->assertEqual(0, $board->getStatForListing(Board::$_player_one_mark, $listing_num));
		}
	}
}
