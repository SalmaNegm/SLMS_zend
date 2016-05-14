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
        $this->materials_model = new Application_Model_DbTable_Material();
    }

    public function indexAction()
    {
        // action body
    }
    #/public/courses/crud
    public function crudAction()
    
    {
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('users/login');
        }
        $data = Zend_Auth::getInstance()->getStorage()->read();
        $is_admin = $data->type;
        if($is_admin != '1')
        {
            $this->redirect('');
        }
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
    		{
    			$data=$this->form->getValues();
                $originalFilePath=$this->form->image->getFileName();
                $path_arr = pathinfo($originalFilePath);
                $newFilename = 'course-' . uniqid() . '.' . $path_arr['extension'];
                rename($originalFilePath, $path_arr['dirname'].'/'.$newFilename);
                $data['image']=$newFilename;
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
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('users/login');
        }
        $data = Zend_Auth::getInstance()->getStorage()->read();
        $is_admin = $data->type;
        if($is_admin != '1')
        {
            $this->redirect('');
        }
    	$id=$this->getRequest()->getParam('cId');
    	
    	if($this->getRequest()->isPost())
    	{
    		if($this->form->isValid($this->getRequest()->getParams()))
			{
				$data = $this->form->getValues();
                $course=$this->model->courseById($id);
                $originalFilePath=$this->form->image->getFileName();
                $path_arr = pathinfo($originalFilePath);
                $newFilename = 'course-' . uniqid() . '.' . $path_arr['extension'];
                rename($originalFilePath, $path_arr['dirname'].'/'.$newFilename);
                $data['image']=$newFilename;
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
    #public/courses/singlecourse/id/2
    public function singlecourseAction()
    {
        $this->layout->setLayout('client');
        $course_id=$this->getRequest()->getParam('id');
        $course=$this->model->courseById($course_id);
        // $materials=$this->model->listByCourseId($course_id);
        // $types=$this->materials_model->getTypesByMaterailId($course_id);
        $materials= $this->materials_model->listByCourseId($course_id);
        // echo "<pre>";
        // var_dump($types);
        // echo "</pre>";
        // echo 'ddddddd's;
        $this->view->course=$course;
        // $this->view->types=$types;
        $this->view->materials=$materials;

    }
    #/public/courses/delete/cId/3
    public function deleteAction()
    {
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('users/login');
        }
        $data = Zend_Auth::getInstance()->getStorage()->read();
        $is_admin = $data->type;
        if($is_admin != '1')
        {
            $this->redirect('');
        }
        $course_id=$this->getRequest()->getParam('cId');
        $course=$this->model->courseById($course_id);
        $r=$this->model->deleteCourse($course_id);
        if($r)
            {
                unlink(APPLICATION_PATH.'/../public/upload/courses/'.$course[0]['image']);
                $this->redirect('courses/crud');               
            }
    }
    #/public/courses/singlecategory/catId/2
    public function singlecategoryAction()
    {
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('users/login');
        }
        $this->layout->setLayout('client');
        $cat_id=$this->getRequest()->getParam('catId');
        $courses=$this->model->listByCategoryId($cat_id);
        $cat=$this->cat_model->getCategoryById($cat_id);
        $this->view->courses=$courses;
        $this->view->category=$cat;
        $this->request_form=new Application_Form_Request();
        $this->view->form = $this->request_form;
        if($this->getRequest()->isPost())
        {
            if($this->request_form->isValid($this->getRequest()->getParams()))
            {
                $data=$this->request_form->getValues();
                $auth = Zend_Auth::getInstance()->getStorage()->read();
                $user_id = $auth->id;
                $this->model_request = new Application_Model_DbTable_Request();
                if($this->model_request->addRequest($data,$user_id))
                    $this->redirect('courses/singlecategory/catId/'.$cat_id);
            }
        }

    }
}