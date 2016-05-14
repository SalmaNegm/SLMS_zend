<?php

class Application_Model_DbTable_Comment extends Zend_Db_Table_Abstract
{

    protected $_name = 'comments';
    function listComments(){
		return $this->fetchAll()->toArray();
	}

	function addComment($commentInfo,$material_id){
		$row = $this->createRow();
		$row->content = $commentInfo['content'];
		$row->publish_date = new Zend_Db_Expr('NOW()');
		$row->material_id = $material_id;
		$row->user_id = 2;
		return $row->save();
	}
	function deleteComment($id){
		return $this->delete('id='.$id);
	}
	function editComment($id,$data){
		 $this->update($data,"id=$id");
	}
	function getCommentById($id){
		return $this->find($id)->toArray();
	}
	function listCommentsByMaterial($material_id){
		return $this->fetchAll($this->select()->where('material_id=?',$material_id));
	}

}

