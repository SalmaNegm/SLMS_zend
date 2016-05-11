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

    public function crudAction()
    {
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
    		{
    			$data=$this->form->getValues();
    			// $data['category_id']=2;
    			// unset($data['category']);
    			// var_dump($data);
                // echo "<br><br>";
    			if($this->model->addCourse($data))
    				$this->redirect('courses/crud');
                // echo APPLICATION_PATH;
                // var_dump($this->getRequest()->getPost());
                // var_dump($this->getRequest()->getQuery());
    		}
    	}
    	$this->form->category_id->setMultiOptions	(array(
    		'1'=>'category1',
    		'2'=>'category2',
    		));
    	$this->view->courses=$this->model->listAll();
    	$this->view->form=$this->form;
    }

    public function editAction()
    {
    	$id=$this->getRequest()->getParam('cId');
    	
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
			{
				$data = $this->form->getValues();
				if ($this->model->edit($data,$id))
					$this->redirect('courses/crud');	
			}
    	}
        $this->form->category_id->setMultiOptions   (array(
            '1'=>'category1',
            '2'=>'category2',
            ));
    	
    	$this->form->submit->setLabel('UPDATE');
    	$course=$this->model->courseById($id);
    	$this->form->populate($course[0]);
        $this->view->form=$this->form;
    }

    public function deleteAction()
    {
        $course_id=$this->getRequest()->getParam('cId');
        $r= $this->model->deleteCourse($course_id);
        if($r)
            $this->redirect('courses/crud');
        else
            echo "nooooooooo";

    }

    public function singlecategoryAction()
    {
        $this->layout->setLayout('client');
        $cat_id=$this->getRequest()->getParam('catId');
        $courses=$this->model->listByCategoryId($cat_id);
        $cat=$this->cat_model->getCategoryById($cat_id);
        // echo "<pre>";
        // var_dump($courses);
        // echo "</pre>";
        // echo 'ddddddd's;
        $this->view->courses=$courses;
        $this->view->category=$cat;

    }


}

