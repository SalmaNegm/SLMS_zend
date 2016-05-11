<?php

class TypesController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Type();
    }

    public function indexAction()
    {
        // action body
        $this->view->MaterialType = $this->model->listMaterialType();
    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_Type();
        
        // $auth =Zend_Auth::getInstance()->getStorage()->read();
        // $user_id=$auth->id;
        // echo $user_id;
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getParams())){
				$data = $form->getValues();
				if ($this->model->addType($data)){
					$this->redirect('types/index');
                }
			}

		}
		$this->view->form = $form;
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->model->deleteType($id))
            $this->redirect('types/index');
    }

    public function editAction()
    {
        // action body
        $id = $this->getRequest()->getParam('id');
        $type = $this->model->getTypeById($id);
        $form = new Application_Form_Type();
        $form->populate($type[0]);
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();

                $this->model->editType($id,$data);   
                $this->redirect('types/index');

            }
        }
        $this->view->form = $form;
    }

}

