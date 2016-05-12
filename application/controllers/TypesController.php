<?php

class TypesController extends Zend_Controller_Action
{

    private $model = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_DbTable_Type();
        $this->layout = $this->_helper->layout();

    }

    public function indexAction()
    {
        // action body
        $this->layout->setlayout('admin');
        $this->view->MaterialType = $this->model->listMaterialType();
    }

    public function addAction()
    {
        // action body
        $this->layout->setlayout('admin');
        $form = new Application_Form_Type();
        
        // $auth =Zend_Auth::getInstance()->getStorage()->read();
        // $user_id=$auth->id;
        // echo $user_id;
		if($this->getRequest()->isPost()){
			if($form->isValid($this->getRequest()->getParams())){
				$data = $form->getValues();
				if ($this->model->addType($data)){
					$this->redirect('types/add');
                }
			}

		}
		$this->view->form = $form;
        $this->view->MaterialType = $this->model->listMaterialType();
    }

    public function deleteAction()
    {
        $this->layout->setlayout('admin');
        $id = $this->getRequest()->getParam('id');
        if($this->model->deleteType($id))
            $this->redirect('types/add');
    }

    public function editAction()
    {
        // action body
        $this->layout->setlayout('admin');
        $id = $this->getRequest()->getParam('id');
        $type = $this->model->getTypeById($id);
        $form = new Application_Form_Type();
        $form->populate($type[0]);
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();

                $this->model->editType($id,$data);   
                $this->redirect('types/add');

            }
        }
        $this->view->form = $form;
        $this->view->MaterialType = $this->model->listMaterialType();
    }

}

