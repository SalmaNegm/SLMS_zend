<?php

class RequestsController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Request();
        $this->user_model = new Application_Model_DbTable_User();
        $this->mat_model = new Application_Model_DbTable_Material();
        $this->layout= $this->_helper->layout();
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) 
        {
            
            $this->redirect('users/login');
        }


        $data = Zend_Auth::getInstance()->getStorage()->read();
     	  $is_admin = $data->type;
     		 if($is_admin == 0 )
     		 {
     		 	$this->redirect('error/error');
     		 }
       
    }

    public function indexAction()
    {
      	$data = Zend_Auth::getInstance()->getStorage()->read();
        $is_admin = $data->type;
      	if($is_admin == 1 )
     		{
     			$requests = $this->model->listRequests();
      		// $names = array();
  	    	// foreach ($requests as  $request) 
  	    	// {
  	    	// 	$user_id = $request['user_id'];
  	    	// 	// echo $user_id;
  	    	// 	$user = $this->user_model->getUserById($user_id);
  	    
  	    	// 	// echo $user[0]['name'];
  	    	// 	array_push($names, $user[0]['name']);
  	    	// }
  	    	// var_dump($requests);

  	    
  	        // $this -> view -> uname = $names;
  	        $this->view->requests = $requests;
  	   			
     		}
    	
    }

    public function listAction()
    {

    	$data = Zend_Auth::getInstance()->getStorage()->read();
      $is_admin = $data->type;
    	if($is_admin == 1 )
   		{
   			$requests = $this->model->isRequestRead();
        $material = $this->mat_model->listMaterial();
   			$this->view->requests = $requests;
        $this->view->material = $material;

   		}

    }

    public function addAction()
    {
        $this->layout->setlayout('admin');
        $form = new Application_Form_Request();
        $data = Zend_Auth::getInstance()->getStorage()->read();
        $user_id = $data->id;

        if($this->getRequest()->isPost())
        {
  				if($form->isValid($this->getRequest()->getParams()))
  				{
  					$data = $form->getValues();
  					if ($this->model->addRequest($data,$user_id))
  					$this->redirect('requests/index');	
  				}

		    }
        $this->view->form = $form;

    }

    public function deleteAction()
    {

        $id = $this->getRequest()->getParam('id');
    		if($this->model->deleteRrquest($id))
    		$this->redirect('requests/index');
    }

    public function editAction()
    {
      $id = $this->getRequest()->getParam('id');
  		$request = $this->model->getRequestById($id);
  		$form = new Application_Form_Request();
  		$form->populate($request[0]);
          
  		if($this->getRequest()->isPost())
  		{
  			if($form->isValid($this->getRequest()->getParams()))
  			{
  				$data = $form->getValues();
  				$this->model->editRequest($id,$data);
  				$this->redirect('requests/index');	
  			}
      
      }
      	
      	$this->view->form = $form;

    }

    public function markAction()
    {
    	$data = Zend_Auth::getInstance()->getStorage()->read();
      $is_admin = $data->type;
    	if($is_admin == 1 )
   		{
   			
   			$id = $this->getRequest()->getParam('id');
	        $request = $this->model->getRequestById($id);
	        $mark = $request[0]['is_read'];
	        $this->model->markRequest($id,$mark);
       		$this->redirect('requests/index');	
   		}
   		else
   		{
   			$this->redirect('error/error');
   		}
        
    }

   


}













