<?php

class CoursesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_Course();
        $this->cat_model = new Application_Model_DbTable_Category();
        $this->form = new Application_Form_Course();
        $this->layout = $this->_helper->layout();
    }

    public function indexAction()
    {
        // action body
    }
    #/public/courses/crud
    public function crudAction()
    {
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
    		{
    			$data=$this->form->getValues();
                $originalFilePath=$this->form->image->getFileName();
                $originalFilename = pathinfo($originalFilePath);

                $newFilename = 'course-' . uniqid() . '.' . $originalFilename['extension'];
    			if($this->model->addCourse($data))
    				{
                        $this->redirect('courses/crud');
                    }
    		}
    	}
    	$this->view->courses=$this->model->listAll();
    	$this->view->form=$this->form;
    }
    #/public/courses/edit/cId/3
    public function editAction()
    {
    	$id=$this->getRequest()->getParam('cId');
    	
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
			{
				$data = $this->form->getValues();
                $course=$this->model->courseById($id);
				if ($this->model->edit($data,$id))
					{
                        unlink(APPLICATION_PATH.'/../public/upload/courses/'.$course[0]['image']);
                        $this->redirect('courses/crud');
                    }	
			}
    	}  	
    	$this->form->submit->setLabel('UPDATE');
    	$course=$this->model->courseById($id);
    	$this->form->populate($course[0]);
        $this->view->form=$this->form;
    }
    #/public/courses/delete/cId/3
    public function deleteAction()
    {
        $course_id=$this->getRequest()->getParam('cId');
        $course=$this->model->courseById($course_id);
        $r=$this->model->deleteCourse($course_id);
        if($r)
            {
                unlink(APPLICATION_PATH.'/../public/upload/courses/'.$course[0]['image']);
                $this->redirect('courses/crud');               
            }
        else
            echo "nooooooooo";
    }
    #/public/courses/singlecategory/catId/2
    public function singlecategoryAction()
    {
        $this->layout->setLayout('client');
        $cat_id=$this->getRequest()->getParam('catId');
        $courses=$this->model->listByCategoryId($cat_id);
        $cat=$this->cat_model->getCategoryById($cat_id);
        $this->view->courses=$courses;
        $this->view->category=$cat;
    }
}