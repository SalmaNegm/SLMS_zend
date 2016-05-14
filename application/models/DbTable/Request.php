<?php

class Application_Model_DbTable_Request extends Zend_Db_Table_Abstract
{

    protected $_name = 'requests';

    function listRequests()
    {
		// return $this->fetchAll()->toArray();

		$select=$this->select('*')
                ->setIntegrityCheck(false)
                
                ->join('users','users.id = requests.user_id',array('name','user_id'=>'id'));
        return $this->fetchAll($select)->toArray();
	}

	function getRequestById($id)
	{
		return $this->find($id)->toArray();
	}

	function getRequestByCourseId($id)
	{
		return $this->fetchAll($this->select()->where('course_id=?',$id));

	}

	function getRequestByuserId($id)
	{
		return $this->fetchAll($this->select()->where('user_id=?',$id));

	}

	function isRequestRead()
	{
		// return $this->fetchAll($this->select()->where('is_read=0'));

		$select=$this->select('*')
                ->setIntegrityCheck(false)
                ->where('requests.is_read=0')
               
                ->join('users','users.id = requests.user_id',array('name','user_id'=>'id'));
        return $this->fetchAll($select)->toArray();
	}


	function addRequest($request,$user_id)
	{

		$row = $this->createRow();
		$row->content = $request['content'];
		$row->user_id = $user_id;

		return $row->save();
	}

	function deleteRrquest($id)
	{
		return $this->delete('id='.$id);
	}

	function editRequest($id,$data)
	{
		return $this->update($data,"id=$id");
	}

	function markRequest($id,$mark)
	{
		
		if($mark == 0)
		{
			$mark = 1;
		}
		elseif($mark == 1)
		{
			$mark = 0;
		}

		$data = array('is_read'  => $mark);

		return $this->update($data,"id=$id");
	}


}

