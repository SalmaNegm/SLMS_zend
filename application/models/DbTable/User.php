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
	$row->name = $userInfo['name'];
	$row->email = $userInfo['email'];
	$row->type = 0;
	$row->gender = $userInfo['gender'];
	// $row->role = $userInfo['role'];


	$row->password = md5($userInfo['password']);
	$row->signature=$userInfo['signature'];
	$row->image=$userInfo['image'];

	return $row->save();
	}




    function editUser($userInfo,$id){
    }

    function changeUser($userInfo,$id){


         $this->update($userInfo,"id=$id");
         
    }



}

