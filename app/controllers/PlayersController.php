<?php

namespace app\controllers;

use app\models\Player;

class PlayersController extends \lithium\action\Controller {

	public function index() {
		$players = Player::all();
		return compact('players');
	}

	public function view() {
		$player = Player::first($this->request->id);
		return compact('player');
	}

	public function add() {
		$player = Player::create();

		if (($this->request->data) && $player->save($this->request->data)) {
			$this->redirect(array('Players::view', 'args' => array($player->id)));
		}
		return compact('player');
	}

	public function edit() {
		$player = Player::find($this->request->id);

		if (!$player) {
			$this->redirect('Players::index');
		}
		if (($this->request->data) && $player->save($this->request->data)) {
			$this->redirect(array('Players::view', 'args' => array($player->id)));
		}
		return compact('player');
	}
}

?>