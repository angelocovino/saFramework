<?php

class ItemsController extends Controller {

	function view($id = null,$name = null) {
	
		$this->setTemplate('title',$name.' - My Todo List App');
		$this->setTemplate('todo',$this->_model
                           ->where('id','=',$id)
                           ->getItemArray('Item')
                          );

	}
	
	function viewall() {

		$this->setTemplate('title','All Items - My Todo List App');
		$this->setTemplate('todo',$this->_model->getItemsArray('Item'));
	}
	
	function add() {
		$todo = $_POST['todo'];
		$this->setTemplate('title','Success - My Todo List App');
		$this->setTemplate('todo',$this->_model->insert(['item_name' => $todo]));	
	}
	
	function delete($id = null) {
		$this->setTemplate('title','Success - My Todo List App');
		$this->setTemplate('todo',$this->_model
                           ->where('id','=',$id)
                           ->delete()
                          );	
	}

}
