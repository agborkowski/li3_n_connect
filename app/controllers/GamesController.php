<?php

namespace app\controllers;

use app\models\Game;
use app\models\Board;
use lithium\storage\Session;

class GamesController extends \lithium\action\Controller {

	public function index() {
		$games = Game::all();
		echo "hi guys!!!!"; exit(); 
		return compact('games');
	}

	public function start() {
		if ($this->request->data) {
			$x = $y = $n = 3; 
			$board = Board::create(compact('x','y','n')); 
			$board->save();
			$player_count = $this->request->data['player_count']; 
			$player_vals = array(Board::$_player_one_mark, Board::$_player_two_mark); 
			if (Session::write("bid", $board->_id) &&  
					Session::write("human_player_count", $player_count) && 
					Session::write("player_turn", $player_vals[rand(0,1)]) 
					) {
				
				$this->redirect(array( 'Games::move'));
			} else {
				echo "there was a problem"; 
			}
		}
		return array(); 
	}
	
	public function move() {

		if (Session::read("bid") != NULL && 
			$board = Board::find("first", array("conditions" => array("_id" => Session::read("bid"))))
			) { 

			if ($this->request->data &&
					isset($this->request->data['x']) &&  
					$this->request->data['x'] > -1 
			){
				error_log("x = " . $this->request->data['x']);
				$board->dropOne($this->request->data['x'], Session::read("player_turn"));
				error_log ($board->getSpotOwner($this->request->data['x'], 1));
			}
			// if computer's turn 
			if (Session::read("human_player_count") == 1 && 
					Session::read("player_turn") == Board::$_player_two_mark) {
					// get the computer's move and make it 
			}
			$this->changePlayerTurn();
			return compact('board');	
		}else {
			echo "dont have a valid bid" ;
		}
		exit();
	}	
	
	protected function changePlayerTurn(){
		if (Session::read('player_turn')) {
			if (Session::read('player_turn') == Board::$_player_one_mark) {
				Session::write('player_turn', Board::$_player_two_mark);
			} else {
				Session::write('player_turn', Board::$_player_one_mark);
			}
			return true;
		} else {
			return false; 
		}
	}
}
