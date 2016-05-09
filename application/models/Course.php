<?php

class Application_Model_Course extends Zend_Db_Table_Abstract
{
 
	protected $_name = "courses";

	function listComments()
	{
		return $this->fetchAll()->toArray();
	}

	function add($courseInfo)
	{
		$row = $this->createRow();
		$row->content=$courseInfo['description'];
		$row->creator=$courseInfo['image'];
		$row->creator=$courseInfo['name'];
		$row->postID=$courseInfo['category_id'];
		return $row->save();
	}
	function delete($id)
	{
		return $this->delete('id='.$id);
	}

	function courseById($id)
	{
		return $this->find($id)->toArray();
	}

	function edit($data,$id)
	{
		return $this->update($data,'id='.$id);
	}

	function listByCategoryId($id)
	{
		return $this->fetchAll($this->select()->where('category_id=?',$id));
	}

}

