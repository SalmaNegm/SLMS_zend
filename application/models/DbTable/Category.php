<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';
    protected $_dependentTables = array('Application_Model_Course');
    function listCategories(){
		return $this->fetchAll()->toArray();
	}

	function addCategory($catInfo){
		$row = $this->createRow();
		$row->name = $catInfo['name'];
		$row->description = $catInfo['description'];
		return $row->save();
	}
	function deleteCategory($id){
		return $this->delete('id='.$id);
	}
	function editCategory($id,$data){
		 $this->update($data,"id=$id");
	}
	function getCategoryById($id){
		return $this->find($id)->current();
	}

	



}

