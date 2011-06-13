<?php

namespace app\tests\cases\models;

use app\models\BoardMap;

class BoardMapTest extends \lithium\test\Unit {
	public function setUp() {}

	public function tearDown() {}

	public function testCreationFalse() {
		$default_x = 7;
		$default_y = 6;
		$default_n = 5;

		$x = $default_x;
		$y = $default_y;
		$n = $default_n;

		//$this->assertFalse(BoardMap::create(array("x" => $x, "y" => $y, "n" => $n)));
		
		$this->assertFalse(BoardMap::create(array("x" => 0, "y" => 0, "n" =>  0)));
		
		$this->assertFalse(BoardMap::create(array("x" => 0, "y" => $y, "n" => $n)));
		$this->assertFalse(BoardMap::create(array("x" => 0, "y" => 0, "n" => $n)));
		$this->assertFalse(BoardMap::create(array("x" => 0, "y" => $y, "n" =>  0)));
		
		$this->assertFalse(BoardMap::create(array("x" => $x, "y" => 0, "n" => $n)));
		$this->assertFalse(BoardMap::create(array("x" => $x, "y" => 0, "n" => 0)));
		
		$this->assertFalse(BoardMap::create(array("x" => $x, "y" => $y, "n" => 0)));
		
		$boardMap = BoardMap::create(compact('x', 'y', 'n'));
		if (! $boardMap) {
			$this->assertFalse(true, "Cannot create real boardMap x:$x, y:$y, n:$n"); 
		}
	}
	
	
	public function testGeneratingListing() {
		for ($n = 4; $n < 5; $n++) {
			// horizontal testing 
			$map = BoardMap::create(array("x" => $n, "y" => 1, "n" =>$n));
			if (! $map) {
				$this->assertFalse(true, "not properly creating BoardMap x: $n, y: 1, n: $n");
				return;  
			}
			
			
			for ($i = 0; $i < $n; $i++) { 
				$listing_1h = $map->getListings($i, 0);
			//	var_dump($listing_1h->to('array')); echo "<br>"; 
				$this->assertEqual(1, count($listing_1h));
			}
			$this->assertEqual(1, $map->getListingCount()); 	
			
			// vertical testing 
			$map = BoardMap::create(array("x" => 1, "y" => $n, "n" =>$n));
			if (! $map) {
				$this->assertFalse(true, "not properly creating BoardMap"); 
			}
			for ($i = 0; $i < $n; $i++) { 
				$listing_1v = $map->getListings($i, 0);
				$this->assertEqual(1, count($listing_1v));
			}
			$this->assertEqual(1, $map->getListingCount()); 	
			
			// diagonals
			$map = BoardMap::create(array("x" => $n, "y" => $n, "n" =>$n));
			if (! $map) {
				$this->assertFalse(true, "not properly creating BoardMap"); 
			}
			for ($i = 0; $i < $n; $i++) { 
				$listing_1v = $map->getListings($i, 0);
				$this->assertTrue(is_array($listing_1v));
				$listing_count = 2; 
				if ($i == 0 || $i == $n-1) {
					$listing_count = 3; 
				}
				$this->assertEqual($listing_count, count($listing_1v));
			}
			$this->assertEqual(($n+$n+2), $map->getListingCount());

		}
	}

	public function testFullBoard() {
		$x = 7; 
		$y = 6;
		$n = 4;

		$board_map = BoardMap::create(compact('x','y','n')); 

		// see http://www.pomakis.com/c4/connect_generic/c4.txt for graph 
		$this->assertEqual(3, count($board_map->getListings(0,0))); 
		$this->assertEqual(4, count($board_map->getListings(0,1))); 
		$this->assertEqual(5, count($board_map->getListings(0,2))); 
		$this->assertEqual(5, count($board_map->getListings(0,3))); 
		$this->assertEqual(4, count($board_map->getListings(0,4))); 
		$this->assertEqual(3, count($board_map->getListings(0,5))); 

		$this->assertEqual(4, count($board_map->getListings(1,0))); 
		$this->assertEqual(6, count($board_map->getListings(1,1))); 
		$this->assertEqual(8, count($board_map->getListings(1,2))); 
		$this->assertEqual(8, count($board_map->getListings(1,3))); 
		$this->assertEqual(6, count($board_map->getListings(1,4))); 
		$this->assertEqual(4, count($board_map->getListings(1,5))); 

		$this->assertEqual(5, count($board_map->getListings(2,0))); 
		$this->assertEqual(8, count($board_map->getListings(2,1))); 
		$this->assertEqual(11, count($board_map->getListings(2,2))); 
		$this->assertEqual(11, count($board_map->getListings(2,3))); 
		$this->assertEqual(8, count($board_map->getListings(2,4))); 
		$this->assertEqual(5, count($board_map->getListings(2,5))); 

		$this->assertEqual(7, count($board_map->getListings(3,0))); 
		$this->assertEqual(10, count($board_map->getListings(3,1))); 
		$this->assertEqual(13, count($board_map->getListings(3,2))); 
		$this->assertEqual(13, count($board_map->getListings(3,3))); 
		$this->assertEqual(10, count($board_map->getListings(3,4))); 
		$this->assertEqual(7, count($board_map->getListings(3,5))); 

		$this->assertEqual(5, count($board_map->getListings(4,0))); 
		$this->assertEqual(8, count($board_map->getListings(4,1))); 
		$this->assertEqual(11, count($board_map->getListings(4,2))); 
		$this->assertEqual(11, count($board_map->getListings(4,3))); 
		$this->assertEqual(8, count($board_map->getListings(4,4))); 
		$this->assertEqual(5, count($board_map->getListings(4,5))); 

		$this->assertEqual(4, count($board_map->getListings(5,0))); 
		$this->assertEqual(6, count($board_map->getListings(5,1))); 
		$this->assertEqual(8, count($board_map->getListings(5,2))); 
		$this->assertEqual(8, count($board_map->getListings(5,3))); 
		$this->assertEqual(6, count($board_map->getListings(5,4))); 
		$this->assertEqual(4, count($board_map->getListings(5,5))); 

		$this->assertEqual(3, count($board_map->getListings(6,0))); 
		$this->assertEqual(4, count($board_map->getListings(6,1))); 
		$this->assertEqual(5, count($board_map->getListings(6,2))); 
		$this->assertEqual(5, count($board_map->getListings(6,3))); 
		$this->assertEqual(4, count($board_map->getListings(6,4))); 
	 	$this->assertEqual(3, count($board_map->getListings(6,5))); 
	}

	public function testGetLocationsByListing() {
		$x = $n = 4; 
		$y = 1;
		$bmap = BoardMap::create(compact('x','y','n')); 
		$listing1 = $bmap->getLocationsByListing(0);
		$this->assertTrue(is_array($listing1));
		for ($i = 0; $i < $x; $i++) {
			$this->assertTrue(isset($listing1[$i]));
			$this->assertEqual(array('x' => $i, 'y' => 0), $listing1[$i]);
		}
		$this->assertFalse($bmap->getLocationsByListing(1)); 
		
		$y = 2; 
		$bmap = BoardMap::create(compact('x','y','n')); 
		for($list_num = 0; $list_num < 2; $list_num++) { 
			$listing = $bmap->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => $i, 'y' => $list_num), $listing[$i]);
			}
		}
		$this->assertFalse($bmap->getLocationsByListing(3)); 


		$x = $n = $y = 4;
		
		$bmap = BoardMap::create(compact('x','y','n')); 
		// horizontal 
		for ($list_num = 0; $list_num < 4; $list_num++) { 
			$listing = $bmap->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => $i, 'y' => $list_num), $listing[$i]);
			}
		}
		
		for ($list_num = 4; $list_num < 8; $list_num++) {
			$listing = $bmap->getLocationsByListing($list_num);
			$this->assertTrue(is_array($listing));
			for ($i = 0; $i < $x; $i++) {
				$this->assertTrue(isset($listing[$i]));
				$this->assertEqual(array('x' => ($list_num-4), 'y' => $i), $listing[$i]);
			}
		}
		
		$listing = $bmap->getLocationsByListing(8); 
		$this->assertTrue(is_array($listing));
		for ($i = 0; $i < 4; $i++) {
			
			$this->assertTrue(isset($listing[$i]));
			$this->assertEqual(array('x' => $i, 'y' => $i), $listing[$i]);
		}
		$listing = $bmap->getLocationsByListing(9); 
		$this->assertTrue(is_array($listing)); 
		for ($i = 0; $i < 4; $i++) {
			$this->assertTrue(isset($listing[$i]));
			$this->assertEqual(array('x' => (3-$i), 'y' =>$i), $listing[$i]);
		}
		
		$this->assertFalse($bmap->getLocationsByListing(10)); 
	}

	public function testGetListingCount() {
		$n = 5; 
		
		for ($i = 0; $i < 7; $i++) { 
			$map = BoardMap::create(array("x" => 1, "y" => ($n+$i), "n" => $n));
			$this->assertEqual(($i+1), $map->getListingCount());

			$map = BoardMap::create(array("y" => 1, "x" => ($n+$i), "n" => $n));
			$this->assertEqual(($i+1), $map->getListingCount());
		}

		$map = BoardMap::create(array("y" => $n, "x" => $n, "n" => $n));
		$this->assertEqual(((2*$n)+2), $map->getListingCount());
		
		$map = BoardMap::create(array("y" => ($n+1), "x" => ($n+1), "n" => $n));
		$this->assertEqual((4 *($n+1)+(2*4)), $map->getListingCount());
	}
}
