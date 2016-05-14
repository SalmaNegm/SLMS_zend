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
	$row->material_type_id=$data['type_id'];
	$row->course_id=$data['course_id'];
	return $row->save();
	}
	function listMaterial(){
		return $this->fetchAll()->toArray();
	}
	function listByCourseId($id)
	{
		return $this->fetchAll($this->select()->where('course_id=?',$id))->toArray();
	}
	function deleteMaterial($id){
		return $this->delete('id='.$id);
	}
	function getMaterialById($id){
		return $this->find($id)->toArray();
	}
	function editMaterial($id,$download,$action){
		// as action is column name in db
		// $material=array('is_download'=>$download);
		$material=array($action=>$download);
		$this->update($material,"id=$id");
	}
	function updateMaterial($id,$no_download){
		// echo $no_download;die();
		$data = array( 
			'no_downloads' => $no_download

			);
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		$this->update($data, $where);

		// $material=$this->fetchRow('id='.$id,1);
		// $material->no_downloads+=1;
		// return $material->save();

 	
 	}

 	function getMaterialByCourseMaterial($course_id,$material_type_id){
 		return $this->fetchAll($this->select()
 			->where('course_id=?',$course_id)
 			->where('material_type_id',$material_type_id));

 	}
 	function getMaterialTypeByCourse($course_id){
 		$course_id=1;
 		// select from table course_material_type
 		return $this->fetchAll($this->select()
 			->where('course_id=?',$course_id));
 	}
 	function getTypesByMaterailId($id){
		$materialTypeTable = new Application_Model_DbTable_Type;
		$materialTypesIds =$this->fetchAll($this->select('material_type_id')->where('course_id=?',$id))->toArray();
		// $type_ids =[];
		foreach ($materialTypesIds as $key => $value) {
			$type_ids[]=$value['material_type_id'];
		}

		$types=$materialTypeTable->find($this->select()->where('id=?',$type_ids))->toArray();
		// $types = $materialTypeTable->select()
  //            ->from(,
  //                   array('id', 'name'))
  //    $select = $this->select()
                $sel = $this->select()
                ->from(array('m' => 'materials'),
						array('id', 'name'))
                ->join(array('t'=>$materialTypeTable),'m.material_type_id','t.id')
                ->where('m.course_id = ?', 1);
			// echo "<pre>";
			// // echo "hdhd";
			// var_dump($sel);
			// echo "</pre>";
			// die;
             return $materialTypesIds[0];
             // return $types;
		
	}
	
	



}

