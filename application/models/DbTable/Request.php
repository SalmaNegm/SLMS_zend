<?php

class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract
{

    protected $_name = 'requests';

    function listRequests()
    {
		return $this->fetchAll()->toArray();
	}

	function getRequestById($id)
	{
		return $this->find($id)->toArray();
	}

	function getRequestByCourseId($id)
	{
		return $this->fetchAll($this->select()->where('course_id=?',$id));

	}

	function getRequestByMatId($id)
	{
		return $this->fetchAll($this->select()->where('material_type_id=?',$id));

	}

	function isRequestRead()
	{
		return $this->fetchAll($this->select()->where('is_read=1'));
	}


	function addRequest($request)
	{

		$row = $this->createRow();
		$row->content = $request['content'];
		$row->user_id = 1;

		return $row->save();
	}


}

