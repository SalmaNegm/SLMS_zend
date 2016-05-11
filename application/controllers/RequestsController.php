<?php

class RequestsController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Request();

    }

    public function indexAction()
    {
    	$requests = $this->model->listRequests();
    	foreach ($requests as  $value) 
    	{
    		$user_id= $value['user_id'];
    	}
    	
    	$this->view->user_id=$user_id; 
        $this->view->requests = $requests;
    }

    public function addAction()
    {
        $form = new Application_Form_Request();

        if($this->getRequest()->isPost())
        {
				if($form->isValid($this->getRequest()->getParams()))
				{
					$data = $form->getValues();
					if ($this->model->addRequest($data))
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
        $id = $this->getRequest()->getParam('id');
        $request = $this->model->getRequestById($id);
        $mark = $request[0]['is_read'];
        $this->model->markRequest($id,$mark);
        $this->redirect('requests/index');	
    }


}









