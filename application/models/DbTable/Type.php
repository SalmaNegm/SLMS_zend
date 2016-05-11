<?php

class Application_Model_DbTable_Type extends Zend_Db_Table_Abstract
{

    
    protected $_name = 'materials_type';

    function listMaterialType(){
		return $this->fetchAll()->toArray();
	}
	function addType($typeInfo){
		$row = $this->createRow();
		$row->name = $typeInfo['name'];
		return $row->save();
	}
	function deleteType($id){
		return $this->delete('id='.$id);
	}
	function getTypeById($id){
		return $this->find($id)->toArray();
	}
	function editType($id,$data){
		 $this->update($data,"id=$id");
	}

}

