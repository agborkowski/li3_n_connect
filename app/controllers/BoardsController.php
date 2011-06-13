<?php

namespace app\controllers;

use app\models\Board;

class BoardsController extends \lithium\action\Controller {

	public function index() {
		$boards = Board::all();
		return compact('boards');
	}

	public function view() {
		$board = Board::first($this->request->id);
		return compact('board');
	}

	public function add() {
		$board = Board::create();

		if (($this->request->data) && $board->save($this->request->data)) {
			$this->redirect(array('Boards::view', 'args' => array($board->id)));
		}
		return compact('board');
	}

	public function edit() {
		$board = Board::find($this->request->id);

		if (!$board) {
			$this->redirect('Boards::index');
		}
		if (($this->request->data) && $board->save($this->request->data)) {
			$this->redirect(array('Boards::view', 'args' => array($board->id)));
		}
		return compact('board');
	}
}

?>