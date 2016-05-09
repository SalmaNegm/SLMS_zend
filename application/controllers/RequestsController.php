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
        $this->view->requests = $this->model->listRequests();
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


}



