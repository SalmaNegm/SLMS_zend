<?php

class Application_Model_DbTable_Material extends Zend_Db_Table_Abstract
{

    protected $_name = 'materials';
    function uploadMaterial($data){
 //    $adapter = new Zend_File_Transfer_Adapter_Http(); 
	// $adapter->setDestination('/application/material/'.$name); 
	// if (!$adapter->receive()) {
 //    $messages = $adapter->getMessages();
 //    echo implode("\n", $messages);
	// }
	$row = $this->createRow();
	$row->name = $data['file'];
	$row->description=$data['description'];
	$row->is_download=$data['is_download'];
	$row->is_show =$data['is_show'];
	$row->no_downloads =0;
	$row->upload_date=new Zend_Db_Expr('NOW()');
	$row->material_type_id=1;
	$row->course_id=1;
	return $row->save();
	}
	function listMaterial(){
		return $this->fetchAll()->toArray();
	}
	function deleteMaterial($id){
		return $this->delete('id='.$id);
	}
	function getMaterialById($id){
		return $this->find($id)->toArray();
	}
	function editMaterial($id,$material){
		$this->update($material,"id=$id");
	}
	



}

