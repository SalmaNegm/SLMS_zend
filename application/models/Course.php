<?php

class Application_Model_Course extends Zend_Db_Table_Abstract
{
 
	protected $_name = "courses";

	protected $_referenceMap    = array(
        'Category' => array(
            'columns'           => 'category_id',
            'refTableClass'     => 'Application_Model_DbTable_Category',
            'refColumns'        => 'id'
        )
    );

	function listAll()
	{
		return $this->fetchAll()->toArray();
	}

	function last5Courses()
	{
		return $this->fetchAll($this->select()->order('id DESC')->limit(5)
    );

	}
	function addCourse($courseInfo)
	{
		$row = $this->createRow();
		$row->description=$courseInfo['description'];
		$row->image=$courseInfo['image'];
		$row->name=$courseInfo['name'];
		$row->category_id=$courseInfo['category_id'];
		return $row->save();
	}
	function deleteCourse($id)
	{
		return $this->delete("id=$id");
		// return $id;
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
		return $this->fetchAll($this->select()->where('category_id=?',$id))->toArray();
	}

	function coursesOfSingleCategory($catId)
	{
		$categoriesTable = new Application_Model_DbTable_Category();
		$categoryRowSet = $categoriesTable->find($catId);
		$category = $categoryRowSet->current();
		 
		$courses = $category->findDependentRowset('Application_Model_Course')->toArray();
		return $courses;
	}


}

