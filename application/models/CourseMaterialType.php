<?php

class Application_Model_CourseMaterialType
{
	protected $_name = "courses_materials_type";

	function assign($info)
	{
		$row = $this->createRow();
		$row->course_id=$info['course_id'];
		$row->material_type_id=$info['material_type_id'];
		return $row->save();
	}

	function reassign($data,$id)
	{
		return $this->update($data,'id='.$id);
	}

	function CoursesByMaterialTypeId($id)
	{
		return $this->fetchAll($this->select()->where('material_type_id=?',$id))->toArray();
	}
}

