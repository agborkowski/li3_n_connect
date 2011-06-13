<?php

namespace app\controllers;

use app\models\BoardMap;

class BoardMapsController extends \lithium\action\Controller {

	public function index() {
		$boardMaps = BoardMap::all();
		return compact('boardMaps');
	}

	public function view() {
		$boardMap = BoardMap::first($this->request->id);
		return compact('boardMap');
	}

	public function add() {
		$boardMap = BoardMap::create();

		if (($this->request->data) && $boardMap->save($this->request->data)) {
			$this->redirect(array('BoardMaps::view', 'args' => array($boardMap->id)));
		}
		return compact('boardMap');
	}

	public function edit() {
		$boardMap = BoardMap::find($this->request->id);

		if (!$boardMap) {
			$this->redirect('BoardMaps::index');
		}
		if (($this->request->data) && $boardMap->save($this->request->data)) {
			$this->redirect(array('BoardMaps::view', 'args' => array($boardMap->id)));
		}
		return compact('boardMap');
	}
}

?>