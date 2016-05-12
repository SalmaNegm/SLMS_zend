<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{

    protected $_name = 'categories';

    function listCategories(){
		return $this->fetchAll()->toArray();
	}
	
	function getegoryCatById($id){
		return $this->find($id)->toArray();
	}
	
	function deleteCategory($id){
		return $this->delete('id='.$id);
	}
	function addCategory(catInfo){
	
	$row = $this->createRow();
	$row->name = $catInfo['name'];
	$row->discription = $catinfo['diccription'];

	return $row->save();
	}
        function editCategory($userInfo,$id){
            $this->update($userInfo,"id=$id");
    }



}

