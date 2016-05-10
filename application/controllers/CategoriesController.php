<?php

class CategoriesController extends Zend_Controller_Action
{

	private $model;
	public function init() {
        $this->model = new Application_Model_DbTable_Category();
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('users/login');
        }
        /* Initialize action controller here */
    }

    public function indexAction() {
        $this->view->categories = $this->model->listcategories();
        //Show Comments
    }

    public function deleteAction() {
        $id = $this->getRequest()->getParam('id');
        if ($this->model->deletecategory($id)) {
            $this->redirect('categories/index');
        }
    }

//     public function showAction() {

//         //Get a single post//

//         $this->view->onecategory = $this->model->getPostById($this->getRequest()->getParam('id'));

//         //Get post Comments//

//         $this->model1 = new Application_Model_DbTable_Comment();
//         $id = $this->getRequest()->getParam('id');
//         $this->view->comments = $this->model1->getCommentsById($id);

//         /*         * *****Comment Form********** */

//         $form = new Application_Form_Comment();
//         //$values = $this->getRequest()->getParams();
//         if ($this->getRequest()->isPost()) {
//             if ($form->isValid($this->getRequest()->getParams())) {
//                 $data = $form->getValues();
//                 $id = Zend_Auth::getInstance()->getStorage()->read()->id;
//                 if ($this->model1->addComment($data, $id)) {
// //                    $this->redirect('posts/index');
//                 }
//             }
//         }
//         //$form->removeElement('submit');
//         $this->view->form = $form;
//     }

//     function logoutAction() {
//         $auth=Zend_Auth::getInstance()->clearIdentity();
//         $this->redirect('users/login');
//     }

    function editAction() {
        $id = $this->getRequest()->getParam('id');
        $post = $this->model->getPostById($id);
        $form = new Application_Form_Category();
        $form->populate($category[0]);
        //$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();

                $this->model->editcategory($data, $id);
            }
        }
        //$form->removeElement('submit');
        $this->view->form = $form;
        $this->render('add');
    }

    public function addAction() {

        $form = new Application_Form_Category();
        //$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
//                var_dump(Zend_Auth::getInstance()->getStorage()->read());
                $id = Zend_Auth::getInstance()->getStorage()->read()->id;
                if ($this->model->addPost($data, $id)) {
                    $this->redirect('categories/index');
                }
            }
        }
        //$form->removeElement('submit');
        $this->view->form = $form;
        //$this->view->pass = "5";
        //$this->redirect('index/index');
    }


}

