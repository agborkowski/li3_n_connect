<?php

namespace app\controllers;

use app\models\Players/CpuPlayer;

class Players/CpuPlayersController extends \lithium\action\Controller {

	public function index() {
		$players/CpuPlayers = Players/CpuPlayer::all();
		return compact('players/CpuPlayers');
	}

	public function view() {
		$players/CpuPlayer = Players/CpuPlayer::first($this->request->id);
		return compact('players/CpuPlayer');
	}

	public function add() {
		$players/CpuPlayer = Players/CpuPlayer::create();

		if (($this->request->data) && $players/CpuPlayer->save($this->request->data)) {
			$this->redirect(array('Players/CpuPlayers::view', 'args' => array($players/CpuPlayer->id)));
		}
		return compact('players/CpuPlayer');
	}

	public function edit() {
		$players/CpuPlayer = Players/CpuPlayer::find($this->request->id);

		if (!$players/CpuPlayer) {
			$this->redirect('Players/CpuPlayers::index');
		}
		if (($this->request->data) && $players/CpuPlayer->save($this->request->data)) {
			$this->redirect(array('Players/CpuPlayers::view', 'args' => array($players/CpuPlayer->id)));
		}
		return compact('players/CpuPlayer');
	}
}

?>