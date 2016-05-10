<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
    
    function listUsers(){
		return $this->fetchAll()->toArray();
	}
	
	function getUserById($id){
		return $this->find($id)->toArray();
	}
	
	function deleteUser($id){
		return $this->delete('id='.$id);
	}
	function addUser($userInfo){
	
	$row = $this->createRow();
	$row->username = $userInfo['username'];
	$row->password = md5($userInfo['password']);

	return $row->save();
	}
        function editUser($userInfo,$id){
            $this->update($userInfo,"id=$id");
    }



}

