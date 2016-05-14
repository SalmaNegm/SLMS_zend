<?php

class CategoriesController extends Zend_Controller_Action
{

	private $model;
	public function init() {
        $this->model = new Application_Model_DbTable_Category();
        // $authorization = Zend_Auth::getInstance();
        // if (!$authorization->hasIdentity()) {
        //     $this->redirect('users/login');
        // }
        $this->form = new Application_Form_Category();
        $this->layout = $this->_helper->layout();
        /* Initialize action controller here */
    }

    public function indexAction() {
        // $this->view->categories = $this->model->listcategories();
        //Show Comments
    }
    #/public/categories/delete/id/2
    public function deleteAction() {
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
        $id=$this->getRequest()->getParam('id');
        $course=$this->model->getCategoryById($id);
        if($this->model->deleteCategory($id))
            {
                $this->redirect('categories/crud');               
            }
    }
    #/public/categories/crud
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
                if($this->model->addCategory($data))
                    {
                        $this->redirect('categories/crud');
                    }
            }
        }
        $this->view->categories=$this->model->listCategories();
        $this->view->form=$this->form;
    }
    #/public/categories/edit/id/2
    public function editAction() {
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
        $id=$this->getRequest()->getParam('id');        
        if($this->getRequest()->isPost())
        {
            if($this->form->isValid($this->getRequest()->getParams()))
            {
                $data = $this->form->getValues();
                if (!$this->model->editCategory($id,$data))
                {
                    $this->redirect('categories/crud');
                }  
            }
        }   
        $this->form->submit->setLabel('UPDATE');
        $category=$this->model->getCategoryById($id)->toArray();
        $this->form->populate($category);
        $this->view->form=$this->form;
    }
}

